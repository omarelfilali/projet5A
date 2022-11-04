<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <p id="modal-body"></p>
            </div>

            <div class="modal-footer">
                <button type="button" style="width: 100%" id="modal-confirm" class="btn btn-success">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<script>
    var modal_title = document.getElementById("modal-title");
    var modal_body = document.getElementById("modal-body");
    var modal_button = document.getElementById("modal-confirm");

    function setModalTitle(title){
        modal_title.innerHTML = title;
    }

    function setModalContent(content){
        modal_body.innerHTML = content;
    }

    function showModal(action){
        $('#modal').modal('show');
        modal_button.setAttribute("onclick", "modalSubmit("+action+")");
    }

    function modalSubmit(action){
        $('#modal').modal("hide");
        action.click();
    }
</script>
