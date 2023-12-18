// import { BASE_URL, USER_DATA, showDialogError, timeConversion, formatRupiah } from "./main.js";
// $(function () {
//     'use strict'
//
//     let meter_last_record = $('#meter_last_record').val();
//
//     let startDate = moment().startOf('month').format('YYYY-MM-DD HH:mm:ss');
//     let endDate = moment(meter_last_record).format('YYYY-MM-DD 00:00:00');
//     let isHide = true
//     let timeExcecution
//     let cardHeaderHeight = $('.card-header').height()
//     let cardFooterHeight = $('.card-header').height()
//     let navbarHeight = $('.navbar').height()
//     let footerHeight = $('footer').height()
//     let recordTable = $('#table-data-record').DataTable({
//         processing: true,
//         serverSide: true,
//         scrollY: (document.documentElement.clientHeight - cardHeaderHeight) - (navbarHeight - footerHeight) - cardFooterHeight - 178,
//         scrollX: true,
//         scrollCollapse: true,
//         pageLength: 100,
//         scrollCollapse: true,
//         fixedColumns: {
//             leftColumns: 2,
//             heightMatch: 'none',
//             widthMatch: 'none'
//         },
//         initComplete: function (settings, json) {
//             $('#table-data-record_length').find('select').addClass('select2');
//             $('#table-data-record_length').find('label').addClass('d-block');
//             $('#table-data-record_length').find('select').removeClass('form-control-sm').addClass('form-control');
//             $('#table-data-record_length').replaceAll($('#lenght'));
//             $('#table-data-record_filter').find('input').removeClass('form-control-sm').addClass("from-control");
//             $('#table-data-record_filter').find('input').attr('placeholder', 'Search');
//             $('#table-data-record_filter').removeClass('mt-2');
//             $('#table-data-record_filter').find('input').addClass('mt-sm-0');
//             $('#table-data-record_filter').find('input').replaceAll($('#search'));
//             $('#table-data-record_wrapper').find("div").slice(1, 4).remove();
//             $('.form-group').css("margin-bottom", 'unset');
//             $('.form-group').css("margin-bottom", '8px');
//             $(".dataTables_length .select2").select2({ minimumResultsForSearch: -1 });
//             $(".dataTables_length .select2").css('font-weight', 'normal');
//             $('#table-data-record_info').replaceAll($('#info'));
//             $('.shimmer').fadeOut(100);
//         },
//         order: [],
//         ajax: {
//             url: BASE_URL + "billing/data/",
//             type: "POST",
//             data: function (d) {
//                 d.start_date = startDate;
//                 d.end_date = endDate;
//             },
//             error: function (err) {
//                 showDialogError(err.statusText);
//             },
//             beforeSend: function () {
//                 let newDate = new Date();
//                 timeExcecution = newDate.getTime();
//             }
//         },
//         drawCallback: function () {
//             let endDate = new Date();
//             let dataTableExecTime = timeConversion(endDate.getTime() - timeExcecution);
//             let info = $('.dataTables_info').text();
//             $('.dataTables_info').html(info + '<span class="text-gray"> (' + dataTableExecTime + ')</span>');
//             $('#table-data-record_paginate').css('display', '');
//             $('#table-data-record_paginate').replaceAll($('#page'));
//         },
//         rowCallback: function (row, data, index) {
//             $(row).find('.condition').addClass('bg-cond-' + data[16])
//         },
//         columnDefs: [
//             {
//                 targets: 0,
//                 orderable: false,
//             },
//             {
//                 targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
//                 class: 'text-right',
//             },
//             {
//                 targets: [14],
//                 class: 'text-center',
//             }
//         ],
//         createdRow: function (row, data, index) {
//             $(row).addClass('changeItem');
//             $(row).click(function () {
//                 $(this).addClass('selected').siblings().removeClass("selected");
//             });
//             let btnPrint = $(row).find('.item-data');
//             btnPrint.click(function () {
//                 $(this).addClass('selected').siblings().removeClass("selected");
//                 let sid = data[15];
//                 window.jsPDF = jspdf.jsPDF;
//                 Swal.fire({
//                     title: 'Processing...',
//                     html: 'Please wait',
//                     onBeforeOpen: () => {
//                         Swal.showLoading();
//                         $.ajax({
//                             url: BASE_URL + 'billing/get_item/',
//                             type: 'POST',
//                             data: {
//                                 meter_sid: sid,
//                                 start_date: startDate,
//                                 end_date: endDate,
//                             },
//                             error: function (err) {
//                                 showDialogError('An Error Occured!')
//                             },
//                             success: function (data) {
//                                 let pdfWidth = $('#print-area').width();
//                                 data = JSON.parse(data)
//                                 $('#header-img').prop('src', 'data:image/png;base64,' + data.bill_logo)
//                                 $('#header-title').text(data.bill_title)
//                                 $('#header-address').text(data.bill_address)
//                                 $('#name').text(data.meter_alias == null || data.meter_alias == "" ? data.meter_name : data.meter_alias + ' (' + data.meter_name + ')')
//                                 $('#period').text(moment(startDate).format('DD-MM-YYYY') + " — " + moment(endDate).format('DD-MM-YYYY'))
//                                 $('#location').text(data.location == null || data.location == "" ? data.meter_name : data.location)
//                                 $('#serial').text(data.meter_serial)
//                                 $('#tarif').text(data.meter_tarif == null || data.meter_tarif == "" ? " — " : formatRupiah(data.meter_tarif))
//                                 $('#factor').text(data.meter_pc_factor == null || data.meter_pc_factor == "" ? " — " : formatRupiah(data.meter_pc_factor))
//                                 $('#mccb').text(data.meter_pc_mccb == null || data.meter_pc_mccb == "" ? " — " : formatRupiah(data.meter_pc_mccb))
//                                 $('#daya').text(data.meter_pc_daya == null || data.meter_pc_daya == "" ? " — " : formatRupiah(data.meter_pc_daya))
//                                 $('#lwbp_usage').text(formatRupiah(data.lwbp))
//                                 $('#wbp_usage').text(formatRupiah(data.wbp))
//                                 $('#lwbp_tarif').text(formatRupiah(data.lwbp_tarif))
//                                 $('#wbp_tarif').text(formatRupiah(data.wbp_tarif))
//                                 $('#lwbp_cost').text(formatRupiah(data.lwbp_cost))
//                                 $('#wbp_cost').text(formatRupiah(data.wbp_cost))
//                                 $('#subtotal').text(formatRupiah(data.subtotal))
//                                 $('#pju_label').text('PJU (' + data.pju + '%)')
//                                 $('#pju').text(formatRupiah(data.count_of_pju))
//                                 $('#total').text(formatRupiah(data.total))
//                                 $('#total2').text(formatRupiah(data.total))
//                                 let ppn = (data.total * data.bill_ppn) / 100
//                                 $('#ppn').text(formatRupiah(parseInt(ppn).toString()))
//                                 $('#ppn_label').text('PPN (' + data.bill_ppn + '%)')
//                                 let grand_total = parseInt(ppn) + parseInt(data.total)
//                                 $('#grand_total').text(formatRupiah(grand_total.toString()))
//                                 $('#pic').text(data.bill_pic)
//
//                                 var doc = new jsPDF("l", "pt", [820, $('#print-area').width() + 100]);
//                                 doc.setProperties({
//                                     title: "Invoice " + data.meter_name,
//
//                                 });
//                                 $('#print-area').show();
//                                 doc.html(document.getElementById('print-area'), {
//                                     callback: function (pdf) {
//                                         Swal.close();
//                                         pdf.output("dataurlnewwindow");
//                                         $('#print-area').hide();
//                                     },
//                                     x: 14,
//                                     y: 14,
//                                     margin: [24, 10, 24, 10],
//                                     filename: "Invoice " + data.meter_name
//                                 });
//                             }
//                         })
//                     }
//                 });
//             });
//         }
//     });
//     $('#table-data-record tbody').addClass('member');
//     $(".dataTables_scrollBody").scroll(function () {
//         if ($(".dataTables_scrollBody").scrollTop() > 0) {
//             $('.dataTables_scrollHead').addClass('border-bottom-line');
//             $('.DTFC_LeftHeadWrapper').addClass('border-bottom-line');
//         } else {
//             $('.dataTables_scrollHead').removeClass('border-bottom-line');
//             $('.DTFC_LeftHeadWrapper').removeClass('border-bottom-line');
//         }
//     });
//
//     $('#print-area').hide();
//
//     initDateFilter()
//
//     $('#refresh-table').click(function () {
//         refreshTable();
//     })
//
//     $('#filter').click(function () {
//         $('.hidable').slideToggle(50);
//         updateFilterState();
//
//     });
//
//     $('#collexp').click(function () {
//         $('.hidable').slideToggle(50);
//         updateFilterState();
//     });
//
//     function updateFilterState() {
//         if (isHide) {
//             $('#collexp').find('i').removeClass("fas fa-caret-down");
//             $('#collexp').find('i').addClass("fas fa-caret-up");
//             $('#filter').html('<i class="cil-vertical-align-top mr-1"></i> Hide Filter');
//             isHide = false
//         } else {
//             $('#filter').html('<i class="cil-filter mr-1"></i> Advanced Filter');
//             $('#collexp').find('i').removeClass("fas fa-caret-up");
//             $('#collexp').find('i').addClass("fas fa-caret-down");
//             isHide = true;
//         }
//     }
//
//     function initDateFilter() {
//         $('#report_filter').val(moment(startDate).format('DD MMM YYYY HH:mm') + ' — ' + moment(endDate).format('DD MMM YYYY HH:mm'));
//         $('#report_filter').daterangepicker({
//             timePicker: true,
//             timePicker24Hour: true,
//             timePickerIncrement: 1,
//             timePickerSeconds: false,
//             autoUpdateInput: false,
//             showDropdowns: true,
//             opens: 'left',
//             locale: {
//                 format: 'DD-MM-YYYY HH:mm',
//                 cancelLabel: 'Clear'
//             },
//             startDate: moment(startDate).format('DD-MM-YYYY HH:mm'),
//             endDate: moment(endDate).format('DD-MM-YYYY HH:mm'),
//             maxDate: moment(endDate).format('DD-MM-YYYY HH:mm')
//         });
//         $('#report_filter').on('apply.daterangepicker', function (ev, picker) {
//             $(this).val(picker.startDate.format('DD MMM YYYY HH:mm') + ' — ' + picker.endDate.format('DD MMM YYYY HH:mm'));
//             startDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
//             endDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
//             recordTable.page(0);
//             recordTable.ajax.reload(null, false);
//         });
//         $('#report_filter').on('cancel.daterangepicker', function (ev, picker) {
//             $(this).val('');
//         });
//         $(".progress-bar").animate();
//     }
//
//     function refreshTable() {
//         recordTable.page(0);
//         recordTable.ajax.reload(null, false);
//     }
//
//     $('#export-data').click(function () {
//         $(this).html('<i class="cil-data-transfer-down mr-1"></i> Downloading...')
//         $(this).attr('disabled', 'disabled')
//         setTimeout(function () {
//             window.location.href = BASE_URL + 'billing/data_export/' + startDate + '/' + endDate
//                 , '_blank'
//             $('#export-data').html('<i class="cil-data-transfer-down mr-1"></i> Export to Excel')
//             $('#export-data').removeAttr('disabled')
//         }, 1000)
//     })
//
// });