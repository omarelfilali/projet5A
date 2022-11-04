<section class="content-header">

    <ol class="breadcrumb" id="olbreadcrumb">
      <div style="display: inline-block;top: -10px;position: relative;height: 28px;">
          @yield('content_header')
      </div>
      <div class="box-tools" style="display: inline-block;top: -10px;position: relative; margin-left: 5px">
          <div>
              <select class="form-control select2" id="pageamount_datatable">
                  <option value="10">10 éléments</option>
                  <option value="25">25 éléments</option>
                  <option value="50">50 éléments</option>
                  <option value="100">100 éléments</option>
              </select>
          </div>
      </div>
      <div class="box-tools" style="display: inline-block;top: -8px;position: relative; margin-left: 5px">
        <div class="input-group" style="width: 200px;">
          <input type="text" id="search_bar_datatable" name="search_bar_datatable" class="form-control input-sm pull-right" placeholder="Rechercher">
        </div>
      </div>
    </ol>

</section>
