<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
class Billing extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->helper("file");
        $this->load->model('Billing_model', 'billing');
    }

    public function index($id = null)
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Billing Data';
        $data['meter_last_record'] = meter_last_record();
        $this->load->view('_partials/header', $data);
        $this->load->view('billing/index', $data);
        $this->load->view('_partials/footer');
    }

    public function data()
    {
        $data = $row = array();
        $role = $this->db->get_where('generic_references',
            array('ref_sid' => $this->session->userdata('user_role_sid'))
        )->row_array();
        $memData = $this->billing->getRows($_POST);
        $i = $_POST['start'];

        foreach ($memData as $member) {
            $i++;
            $data[] = array(
                $i,
                $member->meter_name,
                formatRp($member->meter_start),
                formatRp($member->meter_end),
                formatRp($member->meter_total),
                formatRp($member->lwbp),
                formatRp($member->lwbp_tarif),
                formatRp($member->lwbp_cost),
                formatRp($member->wbp),
                formatRp($member->wbp_tarif),
                formatRp($member->wbp_cost),
                formatRp($member->subtotal),
                formatRp($member->count_of_pju).' ('.$member->pju.')',
                formatRp($member->total),
                '<a href="#" class="item-data badge badge-success pt-1" data-id="'.$member->meter_sid.'">PRINT</a>',
                $member->meter_sid,

            );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->billing->countAll(),
            "recordsFiltered" => $this->billing->countFiltered($_POST),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }

    public function get_item() {
        $sid = $this->input->post('meter_sid'); 
        $start_date = $this->input->post('start_date'); 
        $end_date = $this->input->post('end_date');
        echo json_encode($this->billing->getItem($sid, $start_date, $end_date));
        // echo json_encode($this->billing->getItem($sid, $start_date, $end_date));
    }

    public function data_export($start_date, $end_date)
    {
        set_time_limit(0);
        $unit = $this->master->getGenericBySid($this->session->userdata('user_unit'));

        //ambil data]
        $ulp = $this->input->get("ulp");
        $get = $this->billing->getExportData(urldecode($start_date), urldecode($end_date));
        
        //validasi jumlah data
        if ($get != null)
        {
            $writer = WriterFactory::create(Type::XLSX);
            $filename = 'REPORT_BILLING_'.time().'.xlsx';
            $writer->openToBrowser($filename);
            $header0 = [
                "#",
                "KWH NAME",
                "METER",
                "",
                "",
                "LWBP",
                "",
                "",
                "WBP",
                "",
                "",
                "SUBTOTAL",
                "PJU (%)",
                "TOTAL",
            ];

            $header1 = [
                "",
                "",
                "START",
                "END",
                "TOTAL",
                "USAGE",
                "TARIF",
                "COST",
                "USAGE",
                "TARIF",
                "COST",
                "",
                "",
                "",
            ];

            $style = (new StyleBuilder())
                ->setFontSize(12)
                ->setShouldWrapText()
                ->setFontColor(Color::WHITE)
                ->setFontBold()
                ->setBackgroundColor(Color::GREEN)
                ->build();

            $styletitleHeader = (new StyleBuilder())
                ->setFontSize(14)
                ->setFontBold()
                ->setFontColor(Color::BLACK)
                ->build();

            $styletitle = (new StyleBuilder())
                ->setFontSize(8)
                ->setFontBold()
                ->setFontColor(Color::BLACK)
                ->build();

            $writer->addRowWithStyle(array('REPORT BILLING'), $styletitleHeader);
            $writer->addRow(array('PERIOD : ' . urldecode($start_date) . ' — ' . urldecode($end_date)), $styletitle);
            $writer->addRowWithStyle($header0, $style);
            $writer->addRowWithStyle($header1, $style); 

            $data   = array();
            $i     = 1;

            foreach ($get as $member)
            {
                $row   =  array(
                    $i++,
                    $member['meter_name'],
                    formatRp($member['meter_start']),
                    formatRp($member['meter_end']),
                    formatRp($member['meter_total']),
                    formatRp($member['lwbp']),
                    formatRp($member['lwbp_tarif']),
                    formatRp($member['lwbp_cost']),
                    formatRp($member['wbp']),
                    formatRp($member['wbp_tarif']),
                    formatRp($member['wbp_cost']),
                    formatRp($member['subtotal']),
                    formatRp($member['count_of_pju']).' ('.$member['pju'].')',
                    formatRp($member['total'])
                );

                array_push($data, $row);
            }

            $writer->addRows($data);

            $writer->close(); //tutup spout writer
        }
        else
        {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <div><i class="icon fas fa-exclamation-triangle"></i> <b>Export data failed!</b> <span class="font-weight-light">Data not found or empty  (No matching records found).</span></div>
                </div>');
            redirect('billing');
        }
    }
}