import './bootstrap';
import $ from "jquery";
import 'datatables.net'

$(document).ready(function(){
    $('#QuestionList').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [5],
    });
    $('#QCMPendingList').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [10],
    })
});
