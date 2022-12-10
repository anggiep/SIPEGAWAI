<?php 
/**
 * Cuti Page Controller
 * @category  Controller
 */
class CutiController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "cuti";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"id_pegawai", 
			"tipe_cuti", 
			"tgl_pengajuan", 
			"tgl_mulai", 
			"tgl_selesai", 
			"ket", 
			"status", 
			"tgl_disetujui_atasan", 
			"tgl_disetujui_hrd", 
			"tgl_ditolak_atasan", 
			"tgl_ditolak_hrd", 
			"created_at", 
			"updated_at");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				cuti.id LIKE ? OR 
				cuti.id_pegawai LIKE ? OR 
				cuti.tipe_cuti LIKE ? OR 
				cuti.tgl_pengajuan LIKE ? OR 
				cuti.tgl_mulai LIKE ? OR 
				cuti.tgl_selesai LIKE ? OR 
				cuti.ket LIKE ? OR 
				cuti.status LIKE ? OR 
				cuti.tgl_disetujui_atasan LIKE ? OR 
				cuti.tgl_disetujui_hrd LIKE ? OR 
				cuti.tgl_ditolak_atasan LIKE ? OR 
				cuti.tgl_ditolak_hrd LIKE ? OR 
				cuti.created_at LIKE ? OR 
				cuti.updated_at LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "cuti/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("cuti.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Cuti";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("cuti/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"id_pegawai", 
			"tipe_cuti", 
			"tgl_pengajuan", 
			"tgl_mulai", 
			"tgl_selesai", 
			"ket", 
			"status", 
			"tgl_disetujui_atasan", 
			"tgl_disetujui_hrd", 
			"tgl_ditolak_atasan", 
			"tgl_ditolak_hrd", 
			"created_at", 
			"updated_at");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("cuti.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Cuti";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("cuti/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_pegawai","tipe_cuti","tgl_pengajuan","tgl_mulai","tgl_selesai","ket","status","tgl_disetujui_atasan","tgl_disetujui_hrd","tgl_ditolak_atasan","tgl_ditolak_hrd","created_at","updated_at");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_pegawai' => 'required|numeric',
				'tipe_cuti' => 'required',
				'tgl_pengajuan' => 'required',
				'tgl_mulai' => 'required',
				'tgl_selesai' => 'required',
				'ket' => 'required',
				'status' => 'required',
				'tgl_disetujui_atasan' => 'required',
				'tgl_disetujui_hrd' => 'required',
				'tgl_ditolak_atasan' => 'required',
				'tgl_ditolak_hrd' => 'required',
				'created_at' => 'required',
				'updated_at' => 'required',
			);
			$this->sanitize_array = array(
				'id_pegawai' => 'sanitize_string',
				'tipe_cuti' => 'sanitize_string',
				'tgl_pengajuan' => 'sanitize_string',
				'tgl_mulai' => 'sanitize_string',
				'tgl_selesai' => 'sanitize_string',
				'ket' => 'sanitize_string',
				'status' => 'sanitize_string',
				'tgl_disetujui_atasan' => 'sanitize_string',
				'tgl_disetujui_hrd' => 'sanitize_string',
				'tgl_ditolak_atasan' => 'sanitize_string',
				'tgl_ditolak_hrd' => 'sanitize_string',
				'created_at' => 'sanitize_string',
				'updated_at' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("cuti");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Cuti";
		$this->render_view("cuti/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","id_pegawai","tipe_cuti","tgl_pengajuan","tgl_mulai","tgl_selesai","ket","status","tgl_disetujui_atasan","tgl_disetujui_hrd","tgl_ditolak_atasan","tgl_ditolak_hrd","created_at","updated_at");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_pegawai' => 'required|numeric',
				'tipe_cuti' => 'required',
				'tgl_pengajuan' => 'required',
				'tgl_mulai' => 'required',
				'tgl_selesai' => 'required',
				'ket' => 'required',
				'status' => 'required',
				'tgl_disetujui_atasan' => 'required',
				'tgl_disetujui_hrd' => 'required',
				'tgl_ditolak_atasan' => 'required',
				'tgl_ditolak_hrd' => 'required',
				'created_at' => 'required',
				'updated_at' => 'required',
			);
			$this->sanitize_array = array(
				'id_pegawai' => 'sanitize_string',
				'tipe_cuti' => 'sanitize_string',
				'tgl_pengajuan' => 'sanitize_string',
				'tgl_mulai' => 'sanitize_string',
				'tgl_selesai' => 'sanitize_string',
				'ket' => 'sanitize_string',
				'status' => 'sanitize_string',
				'tgl_disetujui_atasan' => 'sanitize_string',
				'tgl_disetujui_hrd' => 'sanitize_string',
				'tgl_ditolak_atasan' => 'sanitize_string',
				'tgl_ditolak_hrd' => 'sanitize_string',
				'created_at' => 'sanitize_string',
				'updated_at' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("cuti.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("cuti");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("cuti");
					}
				}
			}
		}
		$db->where("cuti.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Cuti";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("cuti/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","id_pegawai","tipe_cuti","tgl_pengajuan","tgl_mulai","tgl_selesai","ket","status","tgl_disetujui_atasan","tgl_disetujui_hrd","tgl_ditolak_atasan","tgl_ditolak_hrd","created_at","updated_at");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'id_pegawai' => 'required|numeric',
				'tipe_cuti' => 'required',
				'tgl_pengajuan' => 'required',
				'tgl_mulai' => 'required',
				'tgl_selesai' => 'required',
				'ket' => 'required',
				'status' => 'required',
				'tgl_disetujui_atasan' => 'required',
				'tgl_disetujui_hrd' => 'required',
				'tgl_ditolak_atasan' => 'required',
				'tgl_ditolak_hrd' => 'required',
				'created_at' => 'required',
				'updated_at' => 'required',
			);
			$this->sanitize_array = array(
				'id_pegawai' => 'sanitize_string',
				'tipe_cuti' => 'sanitize_string',
				'tgl_pengajuan' => 'sanitize_string',
				'tgl_mulai' => 'sanitize_string',
				'tgl_selesai' => 'sanitize_string',
				'ket' => 'sanitize_string',
				'status' => 'sanitize_string',
				'tgl_disetujui_atasan' => 'sanitize_string',
				'tgl_disetujui_hrd' => 'sanitize_string',
				'tgl_ditolak_atasan' => 'sanitize_string',
				'tgl_ditolak_hrd' => 'sanitize_string',
				'created_at' => 'sanitize_string',
				'updated_at' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("cuti.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("cuti.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("cuti");
	}
}
