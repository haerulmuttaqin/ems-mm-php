import { BASE_URL, USER_DATA, generateSid, showDialogError, timeConversion, setupSortable, alertDelete, Toast, showDialogSuccess, showDialogErrorDeleted, showDialogSuccessDeleted } from "./main.js";
$(function () {
    let td_sid = $('#sid').val()
    let checked = 0;
    setupForm()
    function setupForm() {
        $(function () {
            if (td_sid === '') {

            } else {
                loadItem(td_sid)
                $('#edit').click(function () { window.location.href = BASE_URL + 'data/update/' + td_sid })
                $('#label-datatabung').html('&nbsp; <span class="text-gray text-sm">Update :</span> KWH Information')
            }

            $('#submit').click(function (event) {

                Swal.fire({
                    title: 'Processing...',
                    html: 'Please wait',
                    onBeforeOpen: () => {
                        Swal.showLoading();
                        $.ajax({
                            url: BASE_URL + 'api/meter/',
                            type: 'PUT',
                            contentType: "application/json",
                            dataType: "json",
                            data: JSON.stringify(
                                {
                                    meter_sid: td_sid,
                                    meter_alias: $('#meter_alias').val(),
                                    meter_serial: $('#meter_serial').val(),
                                    meter_tarif: $('#meter_tarif').val(),
                                    meter_pc_factor: $('#meter_pc_factor').val(),
                                    meter_pc_mccb: $('#meter_pc_mccb').val(),
                                    meter_pc_daya: $('#meter_pc_daya').val(),
                                    meter_pju: $('#meter_pju').val(),
                                    location: $('#location').val(),
                                    remark: $('#remark').val(),
                                    meter_pju_has_custom: checked,
                                }
                            ),
                            beforeSend: function (request) {
                                request.setRequestHeader("authorization", USER_DATA.user_token);

                            },
                            error: function (err) {
                                showDialogError(err.responseText)
                            },
                            success: function (data) {
                                if (data.status) {
                                    showDialogSuccess(data.message)
                                    setTimeout(function () {
                                        window.location.href = BASE_URL + 'meter/item/' + td_sid
                                    }, 1300);
                                } else {
                                    showDialogError(data.message)
                                }
                            }
                        })
                    }
                });

                event.preventDefault();
            })
        })
    }

    // on edit or view mode
    function loadItem(td_sid) {
        Swal.fire({
            title: 'Loading...',
            html: 'Please wait',
            onBeforeOpen: () => {
                Swal.showLoading();
                $.ajax({
                    url: BASE_URL + 'meter/get_by_sid/' + td_sid,
                    type: 'GET',
                    contentType: "application/json",
                    dataType: "json",
                    error: function (err) {
                        Swal.close();
                        showDialogError(err.responseText)
                    },
                    success: function (data) {
                        Swal.close();
                        if (data.status) {
                            if (data.data != null) {
                                /*------------- SETUP DATA ------------  */
                                setupData(data.data)
                            } else {
                                showDialogError(data.message)
                            }
                        } else {
                            showDialogError(data.message)
                        }
                    }
                })
            }
        });
    }

    function setupData(data) {
        $('#meter_group').val(data.meter_group)
        $('#meter_name').val(data.meter_name)
        $('#meter_alias').val(data.meter_alias)
        $('#meter_serial').val(data.meter_serial)
        $('#meter_tarif').val(data.meter_tarif)
        $('#meter_pc_factor').val(data.meter_pc_factor)
        $('#meter_pc_mccb').val(data.meter_pc_mccb)
        $('#meter_pc_daya').val(data.meter_pc_daya)
        $('#meter_pju').val(data.meter_pju)
        $('#location').val(data.location)
        $('#remark').val(data.remark)

        if (data.meter_pju_has_custom != 1) {
            $('#meter_pju').prop('disabled', true);
            $('#flexCheck').prop('checked', false);
            checked = 0;
        } else {
            $('#meter_pju').prop('disabled', false);
            $('#flexCheck').prop('checked', true);
            checked = 1;
        }
    }

    $('#flexCheck').click(() => {
        // Get the checkbox
        var checkBox = document.getElementById("flexCheck");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true) {
            $('#meter_pju').prop('disabled', false);
            checked = 1;
        } else {
            $('#meter_pju').prop('disabled', true);
            checked = 0;
        }
    })

});