<?php
namespace Drupal\management\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Messenger;

class ManagementController extends ControllerBase{
    public function Listing(){
        $header_table = ['id'=>t('ID'),'first_name'=>t('First Name'),'last_name'=>t('Last Name'),'email'=>t('Email'),
        'phone_number'=>t('Phone Number'),'salary'=>t('Salary'),'hire_date'=>t('Hire Date'),'opt'=>t('Operation'),'
        opt1'=>t('Operation'),];
        $row = [];

        $conn = Database::getConnection();

        $query = $conn->select('management','m');
        $query->fields('m',['id','first_name','last_name','email','phone_number','salary','hire_date']);
        $result = $query->execute()->fetchAll();

        foreach($results as $value){
            $delete = Url::fromUserInput('/management/form/delete/'.$value->id);
            $edit = Url::fromUserInput('/management/form/data?id='.$value->id);

            $row[] = ['id'=>$value->id,'first_name'=>$value->first_name,'last_name'=>$value->last_name,
            'email'=>$value->email,'phone_number'=>$value->phone_number,'salary'=>$value->salary,'
            hire_date'=>$value->hire_date,'opt'=>Link::fromTextAndUrl('Edit',$edit)->toString(),'
            opt1'=>Link::fromTextAndUrl('Delete',$delete)->toString(),];
        }
        $add = Url::fromUserInput('/management/form/data');
        $text = "Add User";
        $data['table'] = ['#type'=>'table','#header'=>$header_table,'#rows'=>$row,'#empty'=>t('
        No record found'),'#caption'=>Link::fromTextAndUrl($text,$add)->toString(),];

        $this->messenger()->addMessage('Record listed');
        return $data;
    }
}