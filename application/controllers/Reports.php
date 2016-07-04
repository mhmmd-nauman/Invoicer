<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->model(array('client_model', 'report_model', 'currency_model', 'settings_model', 'api_model'));
		$this->load->library(array('ion_auth', 'form_validation'));

		if( !$this->ion_auth->logged_in() ) {

			redirect('login');

		}
                if ($this->session->userdata('trial_expired') == 'true') {
                    $alert = array();
                    $alert['alertHeading'] = $this->lang->line('error');
                    $alert['alertContent'] = "Please upgrade your package to continue";

                    $this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

                    redirect("/packages","refresh");
                }
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->user = $this->ion_auth->user()->row();

		$this->data['clients'] = $this->client_model->getAll( $this->data['user']->id );

		$this->data['currencies'] = $this->currency_model->getAll();
		$this->data['allCurrencies'] = $this->data['currencies'];
		$this->data['settings'] = $this->settings_model->getAll( $this->data['user']->id );
		$this->data['keys'] = $this->api_model->getKeys();

		$this->data['reports'] = $this->report_model->getAll( $this->data['user']->id );

	}

	public function index() {

		$this->data['page'] = 'reports';

		$this->load->view('reports', $this->data);

	}

	/**
	 * Get report details
	 * @param  int $reportID
	 */
	public function get($reportID) {

		$theReport = $this->report_model->get($reportID, $this->data['user']->id);

		if( !$theReport ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('reports_get_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('reports', 'location');

		}

		$this->data['page'] = 'reports';
		$this->data['theReport'] = $theReport;

		$this->load->view('reports', $this->data);

	}

	/**
	 * Create new report
	 */
	public function create() {

		//validate the form

		$this->form_validation->set_rules('field_reportTitle', $this->lang->line('report_title_label'), 'required');
		$this->form_validation->set_rules('field_reportClients[]', $this->lang->line('for_clients_label'), 'required');
		$this->form_validation->set_rules('field_reportStatus[]', $this->lang->line('status_label'), 'required');
		$this->form_validation->set_rules('field_reportFrom', $this->lang->line('date_from_label'), 'required');
		$this->form_validation->set_rules('field_reportTo', $this->lang->line('date_to_label'), 'required');
		$this->form_validation->set_rules('field_reportCurrency', $this->lang->line('currency'), 'required');

		if ($this->form_validation->run() == FALSE) {//validation failed

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('reports_get_error2').validation_errors();

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('reports', 'location');

		} else {

			$reportID = $this->report_model->create($_POST, $this->data['user']->id);

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('success');
			$alert['alertContent'] = $this->lang->line('reports_get_success1');

			$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));

			redirect('reports/'.$reportID, 'location');

		}

	}

	/**
	 * Delete report
	 * @param  int $reportID
	 */
	public function delete($reportID) {

		if( $reportID == '' || !$this->report_model->get($reportID, $this->data['user']->id) ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('reports_delete_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('reports', 'location');

		}

		//reportID is all good, delete the report

		$this->report_model->delete($reportID);

		$alert = array();
		$alert['alertHeading'] = $this->lang->line('success');
		$alert['alertContent'] = $this->lang->line('reports_delete_success1');

		$this->session->set_flashdata('success', $this->load->view('alerts/alert_success', $alert, true));

		redirect('reports', 'location');

	}

	/**
	 * Create PDF Report
	 * @param  int $reportID
	 * @return PDF document
	 */
	public function getPDF( $reportID ) {

		$theReport = $this->report_model->get( $reportID, $this->data['user']->id );

		if( !$theReport ) {

			$alert = array();
			$alert['alertHeading'] = $this->lang->line('error');
			$alert['alertContent'] = $this->lang->line('reports_getPDF_error1');

			$this->session->set_flashdata('error', $this->load->view('alerts/alert_error', $alert, true));

			redirect('reports', 'location');

		}

		$this->data['theReport'] = $theReport;

		$this->load->helper(array('dompdf', 'file'));

		$html = $this->load->view('partials/report_pdf', $this->data, true);

		pdf_create($html, $this->config->item('export_report_prepend').$theReport['report']->report_id);

		//echo $html;

	}

}
