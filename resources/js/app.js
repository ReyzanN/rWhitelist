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
    $('#BanList').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [10],
    })
    $('#CandidateTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [10],
    })
});

/*
Modal Ban Candidate
 */
let ModalBan = document.getElementById('ModalBan')
if (ModalBan){
    ModalBan.addEventListener('show.bs.modal', event => {
        let Button = event.relatedTarget
        let DiscordAccountId = Button.getAttribute('data-bs-discordAccountId')
        let Input = document.getElementById('discordAccountId').value = DiscordAccountId
    })
}

/*
Modal Update ban Candidate
*/
let ModalUpdateBan = document.getElementById('ModalUpdateBan')
if (ModalUpdateBan) {
    ModalUpdateBan.addEventListener('show.bs.modal', event => {
        let Button = event.relatedTarget
        let Id = Button.getAttribute('data-bs-id')
        let Reason = Button.getAttribute('data-bs-reason')
        let Expiration = Button.getAttribute('data-bs-expiration')
        //--
        let IdBan = document.getElementById('idBan').value = Id
        let ReasonBan = document.getElementById('ReasonBan').value = Reason
        let ExpirationBan = document.getElementById('ExpirationBan').value = Expiration
    })
}
