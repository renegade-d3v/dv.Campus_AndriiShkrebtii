<?php
declare(strict_types=1);

namespace AndriiShkrebtii\ControllerDemo\Controller\Demo;

class Controller implements \Magento\Framework\App\Action\HttpGetActionInterface

{
    public function execute()
    {
        echo '123';
        exit();
    }
}
