<?php
namespace Drupal\management\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Messenger;
use Drupal\Core\Link;

class ManagementForm extends FormBase {
    public function getFormid(){
        return 'management_form';
    }
    public function buildform(array $form, FormStateInterface $form_state){
        $conn = Database::getConnection();

        $record = [];
        if(isset($_GET['id'])){
            $query = $conn->select('management','m')->condition('id',$_GET['id'])->fields('m');
            $records = $query->execute()->fetchAssoc();
        }
        $form['first_name']=['#type'=>'textfield','#title'=>t('First Name'),'#required'=>TRUE,'#default_value'=>(
            isset($record['first_name'])&&$_GET['id'])? $record['first_name']:'',];
        
        $form['last_name']=['#type'=>'textfield','#title'=>t('Last Name'),'#required'=>TRUE,'#default_value'=>(
            isset($record['last_name'])&&$_GET['id'])? $record['last_name']:'',];

        $form['email']=['#type'=>'textfield','#title'=>t('Email'),'#required'=>TRUE,'#default_value'=>(
            isset($record['email'])&&$_GET['id'])? $record['email']:'',];
        
        $form['phone_number']=['#type'=>'textfield','#title'=>t('Phone Number'),'#required'=>TRUE,'#default_value'=>(
            isset($record['phone_number'])&&$_GET['id'])? $record['phone_number']:'',];

        $form['salary']=['#type'=>'textfield','#title'=>t('Salary'),'#required'=>TRUE,'#default_value'=>(
            isset($record['salary'])&&$_GET['id'])? $record['salary']:'',];

        $form['hire_date']=['#type'=>'textfield','#title'=>t('Hire Date'),'#required'=>TRUE,'#default_value'=>(
            isset($record['hire_date'])&&$_GET['id'])? $record['hire_date']:'',];
        
        $form['action']=['#type'=>'action',];

        $form['action']['submit'] = ['#type' => 'submit','#value' => t('Save'),];

        $form['action']['reset']=['#type'=>'button','#value'=>t('Reset'),'#attributes'=>['onclick'=>'
            this.form.reset(); return false;',],];

        $link = Url::fromUserInput('/management/');

        $form['action']['cancel']=['#markup'=>Link::fromTextAndUrl(t('Back to page'),$link,['attributes
            '=>['class'=>'button']])->toString(),];

        return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state){
        $first_name = $form_state->getValue('first_name');

        if(preg_match('/[^A-Za-z]/', $first_name)){
            $form_state->setErrorByName('first_name',$this->t('First name must be characters only!'));
        }

        if(preg_match('/[^A-Za-z]/', $last_name)){
            $form_state->setErrorByName('last_name',$this->t('Last name must be characters only!'));
        }

    parent::validateForm($form, $form_state);
    }
    public function submitForm(array &$form, FormStateInterface $form_state){
        $field = $form_state->getValue();

        $first_name = $field['first_name'];
        $last_name = $field['last_name'];
        $email = $field['email'];
        $phone_number = $field['phone_number'];
        $salary = $field['salary'];
        $hire_date = $field['hire_date'];

        if(isset($_GET['id'])){
            $field = ['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'
            phone_number'=>$phone_number,'salary'=>$salary,'hire_date'=>$hire_date,];

            $query = \Drupal::database();
            $query->update('management')->fields($field)->condition('id',$_GET['id'])->execute();
            $this->messenger()->addMessage('Successfully updated records');
        }
        else {
            $field = ['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'
            phone_number'=>$phone_number,'salary'=>$salary,'hire_date'=>$hire_date,];

            $query = \Drupal::database();
            $query->insert('management')->fields($field)->execute();
            $this->messenger()->addMessage('Successfully saved records');

            $form_state->setRedirect('management.management_controller_listing');
        }
    }
}

?>