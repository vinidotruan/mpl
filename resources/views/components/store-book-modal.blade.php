<div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="nameModalLabel">New Book</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3" id="">
                        <label for="title" class="col-form-label">Title:</label>
                        <select class="form-select mb-3" id="title">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title-input" class="form-label">Title:</label>
                        <input type="password" class="form-control" id="title-input">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="title-check">
                        <label class="form-check-label" for="title-check">New title</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="upload">Upload</button>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleInput(event) {

    }

</script>
