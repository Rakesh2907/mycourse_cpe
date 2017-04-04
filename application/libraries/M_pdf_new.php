<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf_new {

    public $param;
    public $pdf;

    public function __construct($param = '"en-GB-x","A4-L","","",10,10,10,10,6,3,"L"')
    {
        $this->param =$param;
        $this->pdf = new mPDF('c','A4-L', 0, '', 9, 9, 16, 9, 9, 9);
    }
}
