<?php
declare(strict_types=1);

namespace AndriiShkrebtii\ControllerDemo\Block;

class PersonalInfoBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->getRequest()->getParam('name');
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return (string) $this->getRequest()->getParam('surname');
    }

    /**
     * @return string
     */
    public function getRepoUrl(): string
    {
        return (string) $this->getRequest()->getParam('repourl');
    }

    /**
     * @return string
     */
    public function getFBUrl(): string
    {
        return (string) $this->getRequest()->getParam('fblink');
    }
}
