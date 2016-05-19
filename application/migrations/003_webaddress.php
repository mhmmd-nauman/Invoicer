<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Webaddress extends CI_Migration {
    //ALTER TABLE `users` ADD `owner` INT(11) NULL DEFAULT '0' ;
    public function up() {
                
        $fields = array(
            'webaddress' => array('type' => 'VARCHAR', 'constraint' => 30, 'default' => ''),
            'owner' => array('type' => 'INT', 'default' => 0)
        );
        
        $this->dbforge->add_column('users', $fields);
    }
    
    
    public function down() {
        
        $this->dbforge->drop_column('users', 'webaddress');
        $this->dbforge->drop_column('users', 'owner');
        
    }
}