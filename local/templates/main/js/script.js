$(document)
    .on('show.bs.modal', '#add_task', function(e){
        var $container = $('.modal-body',this);
        var data = {
            'sessid': BX.bitrix_sessid()
        };
        if (e.relatedTarget.getAttribute('data-id')) {
            data.id =  e.relatedTarget.getAttribute('data-id');
        }

        $container.html();

        $.ajax({
            method: 'post',
            url: '/include/ajax/form/task.php',
            data: data,
            success: function(response) {
                $container.html(response)
            },
        });
        //HTTP_BX_AJAX
    })
    .on('show.bs.modal', '#add_executor', function(e){
        var $container = $('.modal-body',this);
        var data = {
            'sessid': BX.bitrix_sessid()
        };
        if (e.relatedTarget.getAttribute('data-id')) {
            data.id =  e.relatedTarget.getAttribute('data-id');
        }

        $container.html();

        $.ajax({
            method: 'post',
            url: '/include/ajax/form/executor.php',
            data: data,
            success: function(response) {
                $container.html(response)
            },
        });
    })
    .on('submit', '.js_ajax_task', function(e) {
        e.preventDefault();
        var form = this;
        var data = new FormData(form);
        var text = '';
        $('#add_task .modal-body .alert').addClass('d-none');
        $.ajax({
            method: 'post',
            url: form.getAttribute('action'),
            processData: false,
            contentType: false,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#add_task .modal-body').html('<div class="alert alert-success">' + response.message + '</div>');
                    if (response.type === 'add') {
                        text += '<tr data-id="' + response.data.id + '">';
                        text += '<td>' + response.data.id + '</td>';
                        text += '<td class="js_el_name">' + response.data.name + '</td>';
                        text += '<td class="js_el_executor">' + response.data.executor + '</td>';
                        text += '<td class="js_el_status">' + response.data.status + '</td>';
                        text += '<td>';
                        text += '<a href="#" data-toggle="modal" data-target="#add_task" data-id="' +
                            response.data.id + '">edit</a>';
                        text += ' / ';
                        text += '<a href="#" data-id="' + response.data.id + '" class="js_delete_task">delete</a>';
                        text += '</td>';
                        text += '</tr>';
                        if (text) {
                            $('.js_container_task').append(text);
                        }
                    } else if (response.type === 'upd') {
                        $('.js_container_task tr[data-id='+response.data.id+'] .js_el_name').html(response.data.name);
                        $('.js_container_task tr[data-id='+response.data.id+'] .js_el_executor').html(response.data.executor);
                        $('.js_container_task tr[data-id='+response.data.id+'] .js_el_status').html(response.data.status);
                    }
                } else {
                    $('#add_task .modal-body .alert').removeClass('d-none').html(response.message);
                }
            },
        });
    })
    .on('submit', '.js_ajax_executor', function(e) {
        e.preventDefault();
        var form = this;
        var data = new FormData(form);
        var text = '';
        $('#add_executor .modal-body .alert').addClass('d-none');
        $.ajax({
            method: 'post',
            url: form.getAttribute('action'),
            processData: false,
            contentType: false,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#add_executor .modal-body').html('<div class="alert alert-success">' + response.message + '</div>');
                    if (response.type === 'add') {
                        text += '<tr data-id="' + response.data.id + '">';
                        text += '<td>' + response.data.id + '</td>';
                        text += '<td class="js_el_name">' + response.data.name + '</td>';
                        text += '<td class="js_el_position">' + response.data.position + '</td>';
                        text += '<td>';
                        text += '<a href="#" data-toggle="modal" data-target="#add_executor" data-id="' +
                            response.data.id + '">edit</a>';
                        text += ' / ';
                        text += '<a href="#" data-id="' + response.data.id + '" class="js_delete_executor">delete</a>';
                        text += '</td>';
                        text += '</tr>';
                        if (text) {
                            $('.js_container_executor').append(text);
                        }
                    } else if (response.type === 'upd') {
                        $('.js_container_executor tr[data-id='+response.data.id+'] .js_el_name').html(response.data.name);
                        $('.js_container_executor tr[data-id='+response.data.id+'] .js_el_position').html(response.data.position);
                    }
                } else {
                    $('#add_executor .modal-body .alert').removeClass('d-none').html(response.message);
                }
            },
        });
    })
    .on('click', '.js_delete_task', function(e) {
        var $container = $('#message .modal-body');
        var data = {
            'sessid': BX.bitrix_sessid(),
            id: this.getAttribute('data-id')
        };
        var text = '';

        $.ajax({
            method: 'post',
            url: '/ajax/task/delete.php',
            data: data,
            dataType: 'json',
            success: function(response) {
                text += '<div class="' + (response.status ? 'alert-success' : 'alert-danger') + '">';
                text += response.message;
                text += '</div>';

                $container.html(text);
                $('#message').modal('show');
                if (response.status) {
                    $('.js_container_task tr[data-id='+data.id+']').remove();
                }
            },
        });
    })
    .on('click', '.js_delete_executor', function(e) {
        var $container = $('#message .modal-body');
        var data = {
            'sessid': BX.bitrix_sessid(),
            id: this.getAttribute('data-id')
        };
        var text = '';

        $.ajax({
            method: 'post',
            url: '/ajax/executor/delete.php',
            data: data,
            dataType: 'json',
            success: function(response) {
                text += '<div class="' + (response.status ? 'alert-success' : 'alert-danger') + '">';
                text += response.message;
                text += '</div>';

                $container.html(text);
                $('#message').modal('show');
                if (response.status) {
                    $('.js_container_executor tr[data-id='+data.id+']').remove();
                }
            },
        });
    })
;