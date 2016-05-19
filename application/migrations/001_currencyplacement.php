<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Currencyplacement extends CI_Migration {
    
    public function up() {
                
        $fields = array(
            'currency_placement' => array('type' => 'VARCHAR', 'constraint' => 25, 'default' => 'before')
        );
        
        $this->dbforge->add_column('config', $fields);
    }
    
    
    public function down() {
        
        $this->dbforge->drop_column('config', 'currency_placement');
        
    }
}