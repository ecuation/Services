<?php  
namespace App\Services;

class Flash
{
	public function create($title, $message, $notice)
	{
		session()->flash('flash_message', [
			'title' => $title, 
			'message' => $message, 
			'notice' => $notice
		]);
	}

	public function message($title, $message)
	{
		$this->create($title, $message, 'info');
	}

	public function success($title, $message)
	{
		$this->create($title, $message, 'success');
	}

	public function warning($title, $message)
	{
		$this->create($title, $message, 'warning');
	}

	public function error($title, $message)
	{
		$this->create($title, $message, 'error');
	}
}

?>