<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\ParticipantsBlockControl;
use App\FrontModule\Components\ParticipantsBlockFactory;
use App\FrontModule\Components\PartnersBlockControl;
use App\Model\Model;
use Aprila\Website\SiteLayout;
use Nittro;

class BasePresenter extends Nittro\Bridges\NittroUI\Presenter
{

    /** @var SiteLayout @inject */
    public $siteLayout;

    /** @var PartnersBlockControl @inject */
    public $partnersBlock;

    /** @var ParticipantsBlockFactory @inject */
    public $participantsFactory;

    /** @var Model @inject */
    public $model;

    /** @var string */
    public $title;

    /** @var int */
    public $campCapacity;

    /** @var bool */
    public $disableRegistration;

    protected function startup(): void
    {
        parent::startup();

        $this->title = 'Nette Camp / 20.—23. srpna 2020';

        $this->setDefaultSnippets(['content', 'navigation']);

        $this->disableRegistration = $this->siteLayout->get('disableRegistration', false);
        $this->campCapacity = $this->siteLayout->get('campCapacity', 50);
    }


    public function beforeRender(): void
    {
        parent::beforeRender();

        $this->template->production = !$this->siteLayout->get('develMode');
        $this->template->version = $this->siteLayout->get('version');
        $this->template->title = $this->title;
        $this->template->disableRegistration = $this->disableRegistration;
        $this->template->campCapacity = $this->campCapacity;
    }


    public function createComponentPartnersBlock(): PartnersBlockControl
    {
        $control = $this->partnersBlock;
        return $control;
    }


    public function createComponentParticipants(): ParticipantsBlockControl
    {
        $control = $this->participantsFactory->create($this->campCapacity, $this->disableRegistration);
        return $control;
    }

}
