<?php

namespace App\Livewire;

use Livewire\Component;

class ParentView extends Component
{
    public $showDashboard = false;
    public $showSales = true;
    public $showNotification = false;
    public $showCouriers = false;
    public $showOrders = false;
    public $showBookings = false;

    public function gotoDashboard(){
        $this->showDashboard = true;
        $this->showSales = false;
        $this->showNotification = false;
        $this->showCouriers = false;
        $this->showOrders = false;
        $this->showBookings = false;

    }

    public function gotoSales(){
        $this->showSales = true;
        $this->showNotification = false;
        $this->showCouriers = false;
        $this->showOrders = false;
        $this->showBookings = false;
        $this->showDashboard = false;
    }

    public function gotoCouriers(){
        $this->showCouriers = true;
        $this->showNotification = false;
        $this->showOrders = false;
        $this->showDashboard = false;
        $this->showSales = false;
        $this->showBookings = false;
    }

    public function gotoOrders(){
        $this->showOrders = true;
        $this->showNotification = false;
        $this->showCouriers = false;
        $this->showDashboard = false;
        $this->showSales = false;
        $this->showBookings = false;
    }

    public function gotoBookings(){
        $this->showBookings = true;
        $this->showNotification = false;
        $this->showCouriers = false;
        $this->showOrders = false;
        $this->showDashboard = false;
        $this->showSales = false;
       
    }

    public function gotoNotification(){
        $this->showNotification = true;
        $this->showCouriers = false;
        $this->showOrders = false;
        $this->showDashboard = false;
        $this->showSales = false;
        $this->showBookings = false;
    }

    
    public function render()
    {
        return view('livewire.parent-view');
    }
}
