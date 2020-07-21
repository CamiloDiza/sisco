<?php
	require_once dirname(dirname(__FILE__))."/config/config.php";

	class Security
	{
		public static function encryption($string)
		{
			$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    		$qEncoded  = md5( $string );
    		return( $qEncoded );
		}
		
		protected static function decryption($string)
		{
			$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		    $qDecoded  = md5( $string );
		    return( $qDecoded );
		}

		protected function get_random_code($letter, $length, $number)
		{
			for ($i=1; $i<=$length; $i++) 
			{ 
				$num = rand(0,9);
				$letter.= $num; 
			}
			return $letter.'-'.$number; 
		}

		public function clear_string($str)
		{
			$str = trim($str);
			$str = stripcslashes($str);
			$str = str_ireplace('<scrip>', '', $str);
			$str = str_ireplace('</scrip>', '', $str);
			$str = str_ireplace('<scrip src>', '', $str);
			$str = str_ireplace('<scrip type>', '', $str);
			$str = str_ireplace('SELECT * FROM', '', $str);
			$str = str_ireplace('DELETE FROM', '', $str);
			$str = str_ireplace('INSERT INTO', '', $str);
			$str = str_ireplace('--', '', $str);
			$str = str_ireplace('^', '', $str);
			$str = str_ireplace('^', '', $str);
			$str = str_ireplace('[', '', $str);
			$str = str_ireplace(']', '', $str);
			$str = str_ireplace('==', '', $str);
			$str = str_ireplace(';', '', $str);

			return $str;
		}
	}