<?php
namespace 'docker';
class BadFolderLocation{}
class Docker {
	private all_docker_secrets;
	private all_docker_configs:
	private docker_secrets_folder_location;
	private docker_configs_folder_location;

	function __construct($secrets_folder = '/run/secrets/',$configs_folder = '/')
	{
		$this->all_docker_secrets = array();
		$this->all_docker_configs = array();
		try {
			if(Is_This_A_Valid_File_Or_Directory($secrets_folder) && Is_This_A_Valid_File_Or_Directory($configs_folder))
			{
				$this->docker_secrets_folder_location = $secrets_folder;
				$this->docker_configs_folder_location = $configs_folder;
			}else
			{
				throw new BadFolderLocation("The secret or configs folder location is not a valid location");
			}
		} catch (BadFolderLocation $e)
		{
			throw new BadFolderLocation($e->getMessage());
		} catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
		}
	}

	private function Populate_Docker_Secrets()
	{
		$dir = new DirectoryIterator($this->docker_secrets_folder_location);
		foreach ($dir as $fileinfo) {
    		if (!$fileinfo->isDot())
		{
        		$fileinfo->getFilename();
    		}
	}

	private function Is_This_A_Valid_File_Or_Directory($folder_to_validate)
	{
		try {
			if(file_exists($folder_to_validate))
			{
				return true;
			} else
			{
				return false;
			}
		} catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
		}
	}
}
?>
