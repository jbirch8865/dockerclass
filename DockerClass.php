<?php
namespace 'docker';
class BadFolderLocation{}
class SecretDoesNotExist{}
class ConfigDoesNotExist{}

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
				$this->Populate_Docker_Secrets();
				$this->Populate_Docker_Configs();
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

	public function Get_Secret_Value($Secret_To_Get)
	{
		try {
			if(is_set($this->All_Docker_Secrets[$Secret_To_Get]))
			{
				return $this->All_Docker_Secrets[$Secret_To_Get];
			}else
			{
				throw new SecretDoesNotExist($Secret_To_Get." does not appear to be a valid secret");
			}
		}catch (SecretDoesNotExist $e)
		{
			throw new SecretDoesNotExist($e->getMessage());
		}catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
		}
	}

	public function Get_Config_Value($Config_To_Get)
	{
		try {
			if(is_set($this->All_Docker_Configs[$Config_To_Get]))
			{
				return $this->All_Docker_Configs[$Config_To_Get];
			}else
			{
				throw new ConfigDoesNotExist($Config_To_Get." does not appear to be a valid config");
			}
		}catch (ConfigDoesNotExist $e)
		{
			throw new ConfigDoesNotExist($e->getMessage());
		}catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
		}
	}

	private function Populate_Docker_Secrets()
	{
		try {
			$dir = new DirectoryIterator($this->docker_secrets_folder_location);
			foreach ($dir as $fileinfo) {
    			if (!$fileinfo->isDot())
			{
				myfile = fopen($fileinfo->getFilename(), "r");
        			$this->all_docker_secrets[$fileinfo->getFilename()] = fread($myfile,filesize($fileinfo->getFilename()));
				fclose($myfile);
    			}
		} catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
		}
	}

	private function Populate_Docker_Configs()
	{
		try {
			$dir = new DirectoryIterator($this->docker_configss_folder_location);
			foreach ($dir as $fileinfo) {
    			if (!$fileinfo->isDot())
			{
				myfile = fopen($fileinfo->getFilename(), "r");
        			$this->all_docker_configs[$fileinfo->getFilename()] = fread($myfile,filesize($fileinfo->getFilename()));
				fclose($myfile);
    			}
		} catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
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
