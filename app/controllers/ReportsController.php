<?php

class ReportsController extends BaseController {

	public function showReports()
	{
		$this->data['sidenav']['reports']['page_selected'] = true;

		$this->data['reports'] = Report::paginate(20);
		if(isset($_GET['showAll']))
		{
			$this->data['reports'] = Report::all();
		}

    	return View::make('reports/main')->with('data', $this->data);
	}

	public function showReport($entry_report_id='')
	{	
		$this->data['sidenav']['reports']['page_selected'] = true;

		$this->data['report'] = !empty($entry_report_id) ? Report::find($entry_report_id) : new Reports;

		return View::make('reports/edit')->with('data', $this->data);
	}

	public function saveReport()
	{
		$this->data['sidenav']['reports']['page_selected'] = true;

		$this->data['errors'] = array();
				
		if(isset($_POST['entry_report_id']))
		{
			$this->data['report'] = Report::find($_POST['entry_report_id']);
		}
		else
		{	
			$this->data['report'] = new Report;
		}

		$this->data['report']->entry_report_report_reason 			= $_POST['entry_report_report_reason'];

		if(empty($this->data['errors']))
		{
			$this->data['report']->save();
			return Redirect::to('reports');
		}
		else
		{
			return View::make('reports/edit')->with('data', $this->data);	
		}
	}

}
