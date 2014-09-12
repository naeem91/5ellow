<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Search extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('profile/profile_model');
			$this->load->model('group/group_model');

		}
		
		public function do_search()
		{
			$q = strtolower($_GET["term"]);
			if (!$q) return;
			
			$items1 = $this->profile_model->get_all_members('TRUE');
			$items2 = $this->group_model->group_search();
			
			//$items = array_merge($items1,$items2);
			//var_dump($items);
			
			$result =array();
			foreach ($items1 as $key=>$value) 
			{
				if (strpos(strtolower($key), $q) !== false) 
				{
					
					array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key),"type" => 'user'));
				}
	
				if (count($result) > 11)
					break;
			}
			foreach ($items2 as $key=>$value) 
			{
				if (strpos(strtolower($key), $q) !== false) 
				{
					
					array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key),"type" => 'group'));
				}
	
				if (count($result) > 11)
					break;
			}
			
			echo $this->array_to_json($result);

		}
		
		function array_to_json( $array )
		{
			if( !is_array( $array ) )
			{
        		return false;
    		}

    		$associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    		if( $associative )
			{
        		$construct = array();
        		foreach( $array as $key => $value )
				{
            		// We first copy each key/value pair into a staging array,
            		// formatting each key and value properly as we go.

            		// Format the key:
            		if( is_numeric($key) )
					{
                		$key = "key_$key";
            		}
            		$key = "\"".addslashes($key)."\"";

            		// Format the value:
            		if( is_array( $value ))
					{
                		$value = $this->array_to_json( $value );
            		} 
					else if( !is_numeric( $value ) || is_string( $value ) )
					{
                		$value = "\"".addslashes($value)."\"";
            		}
            
					// Add to staging array:
            		$construct[] = "$key: $value";
        		}

        		// Then we collapse the staging array into the JSON form:
       			 $result = "{ " . implode( ", ", $construct ) . " }";

    		} 
			else 
			{ 
				// If the array is a vector (not associative):
        		$construct = array();
        		foreach( $array as $value )
				{
            		// Format the value:
            		if( is_array( $value ))
					{
                		$value = $this->array_to_json( $value );
            		} 
					else if( !is_numeric( $value ) || is_string( $value ) )
					{
                		$value = "'".addslashes($value)."'";
            		}

            		// Add to staging array:
            		$construct[] = $value;
        		}

        			// Then we collapse the staging array into the JSON form:
        			$result = "[ " . implode( ", ", $construct ) . " ]";
    		}

    		return $result;
		}
	}