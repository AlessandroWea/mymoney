<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Category;
use Alewea\Mymoney\models\Operation;
use Alewea\Mymoney\core\Auth;

class Analytics extends Controller
{
    public array $date_types = [
        'this-month', 'last-month', 'this-year', 'last-year', 'all'
    ];

    public function runBefore()
    {
        Auth::logged_in() ? true : $this->redirect('login');
    }

    public function index()
    {
        $page_name = 'analytics';

        $this->view('analytics/index', compact('page_name'));
    }

    public function overview($type = '')
    {
        if(empty($type)) {$this->redirect('analytics');}

        $type = Category::strTypeToIntType($type);
        $date_type = 'this-month';
        $operation = new Operation();
        $total = 0;
        $dataPoints = [];
        $data = [];

        if($this->isPost())
        {
            if(isset($this->date_types[$_POST['date_type']]))
            {
                $date_type = $this->date_types[$_POST['date_type']];
            }
        }

        if(!empty($_SESSION['ACTIVE_ACCOUNT']))
        {
            $range = $this->getDateRangeByType($date_type);
           
            $data = $operation->get_total_value_by_categories(
                $_SESSION['ACTIVE_ACCOUNT']['id'],
                $type == Category::$TYPE_INCOME ? Category::$TYPE_INCOME : Category::$TYPE_EXPENSIS,
                $range['start_date'],
                $range['end_date']);
        }
        
        if($data)
        {
            foreach($data as $row)
            {
                $total += $row['value'];
            }
    
            $index = 0;
            foreach($data as $row)
            {
                $dataPoints[$index]['label'] = $row['category'];
                $dataPoints[$index]['y'] = $row['value'] * 100 / $total;
                $index++;
            }
        }

        $this->view('analytics/overview', [
            'data' => $data,
            'current_date_type' => $date_type,
            'total' => $total,
            'type' => $type,
            'dataPoints' => $dataPoints,
        ]);
    }

    public function getDateRangeByType(string $type)
    {
        $range = [];
        switch($type)
        {
            case 'this-month':
                $range['start_date'] = date('Y-m-1');
                $range['end_date'] = date('Y-m-1', strtotime(' + 1 month'));
                break;
            case 'last-month':
                $range['start_date'] = date('Y-m-1', strtotime(' - 1 month'));
                $range['end_date'] = date('Y-m-1');
                break;
            case 'this-year':
                $range['start_date'] = date('Y-1-1');
                $range['end_date'] = date('Y-1-1', strtotime(' + 1 year'));
                break;
            case 'last-year':
                $range['start_date'] = date('Y-1-1', strtotime(' - 1 year'));
                $range['end_date'] = date('Y-1-1');
                break;
            case 'all':
                $range['start_date'] = '';
                $range['end_date'] = '';
                break;
            default:
                $range['start_date'] = '';
                $range['end_date'] = '';
        }

        return $range;
    }
}