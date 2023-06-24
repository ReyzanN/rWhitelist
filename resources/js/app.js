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
    $('#CandidateListeForSession').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        }
    })
    $('#TableSessionCandidate').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [3],
    })
    $('#TableArchiveSession').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [10],
    })
    $('#AuthRoutingLog').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [5,10,20,30,40,50]
    })
    $('#ActionLog').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [5,10,20,30,40,50]
    })
    $('#RoutingLog').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        },
        lengthMenu: [5,10,20,30,40,50]
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

/*
Modal outcome appointment
*/
    /*
    Valid
     */
let ModalValid = document.getElementById('ValidUser')
if (ModalValid) {
    ModalValid.addEventListener('show.bs.modal', event => {
        let Button = event.relatedTarget
        let Link = Button.getAttribute('data-bs-link')
        //--
        let LinkHref = document.getElementById('ValidUserLink').href = Link
    })
}

    /*
    Refused
     */
let RefusedUser = document.getElementById('RefusedUser')
if (RefusedUser) {
    RefusedUser.addEventListener('show.bs.modal', event => {
        let Button = event.relatedTarget
        let Link = Button.getAttribute('data-bs-link')
        //--
        let LinkHref = document.getElementById('RefusedLink').href = Link
    })
}

    /*
    Refused Permanent
     */
let PermaRefused = document.getElementById('PermaRefused')
if (PermaRefused) {
    PermaRefused.addEventListener('show.bs.modal', event => {
        let Button = event.relatedTarget
        let Link = Button.getAttribute('data-bs-link')
        //--
        let LinkHref = document.getElementById('PermanentRefusedLink').href = Link
    })
}

/*
 Modal Conform Registration Candidate Session
 */
let ConformationSession = document.getElementById('ConformationSession')
if (ConformationSession) {
    ConformationSession.addEventListener('show.bs.modal', event => {
        let Button = event.relatedTarget
        let IdSession = Button.getAttribute('data-bs-session')
        //--
        let Input = document.getElementById('idSessionInput').value = IdSession
    })
}
