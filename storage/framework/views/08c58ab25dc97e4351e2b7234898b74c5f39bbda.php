<style>
    .save_set {
        position: fixed;
        top: 0;
        right: 0;
        z-index: 999;
        left: 0;
        margin: 0 auto;
        width: 30%;
    }
</style>
<div class="card main_data">
    <div class="card-body">
        <div class="row" id="show_data">

        </div>
        <?php if(is_null($id)): ?>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-secondary" id="add_more">Duplicate</button>
                    <a class="btn btn-danger d-none btn_remove"> Remove </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="appended_data">

</div>
<div class="row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary form-control save_set">Save Settings</button>
    </div>
</div>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/sync-settings/form.blade.php ENDPATH**/ ?>