<?php
	include $MositeDirName . 'database'.DIRECTORY_SEPARATOR.'database_function.php';

	class Mosite_Constants
	{
		
		const DEFAULT_CUSTOMER_KEY		= "16555";
		const DEFAULT_API_KEY 			= "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";
		const DB_VERSION				= 100;
		const ERROR_404					= "404";

		const HOST_NAME					= "https://login.xecurify.com";
	
		function __construct()
		{
			$this->mosa_define_global();
		}

		function mosa_define_global()
		{
			global $SiteDbQueries,$MositeDirName;
			$SiteDbQueries	 	= new MoSite_DB();
			$MositeDirName 		= dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR;
			
		}
		
	}
	new Mosite_Constants;

?>