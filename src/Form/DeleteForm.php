<?php
namespace Drupal\management\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Messenger;

class DeleteForm extends ConfirmFormBase{
    public function getformId(){
        return 'delete_form';
    }
    public $cid;

    public function getQuestion(){
        return t('Delete Records?');
    }
    public function getCancelUrl(){
        return new Url('management.management_controll_listing');
    }
    public function getDescription(){
        return t('Are you sure Do you want to delete record?');
    }
    public function getConfirmText(){
        return t('Delete it');
    }
    public function getCancelText(){
        return t('Cancel');
    }
    public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL){
        $this->id = $cid;
        return parent::buildForm($form, $form_state);
    }
    public function validateForm(array &$form, FormStateInterface $form_state){
        parent::validateForm($form, $form_state);
    }
    public function submitForm(array &$form, FormStateInterface $form_state){
        $query = \Drupal::database();
        $query->delete('management')->condition('id',$this->id)->execute();

        $this->messenger()->addMessage('Successfully deleted record');
        $form_state->setRedirect('management.management_controller_listing');
    }
}

?>