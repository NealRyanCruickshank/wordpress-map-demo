<div class="row full" style="height:100vh;">
    <div class="col col-sm-3 full" style="overflow: auto;">
        <h4 style="text-align:center">
            <img src="<?php echo plugin_dir_url( __FILE__ )?>../images/courier-guy-logo.png" style="width:125px">
        </h4>
        <hr>
        <button class="btn form-control" style="border: 1px solid #000;" onclick="confirmLocations()">Request Delivery</button>
        <p>
        <div class="row">
          <input id="from-code" hidden>
          <input id="to-code" hidden>
          <div class="col-sm-12">Pickup Location : <input id="from" class="form-control" readonly style="background-color:white;"/></div>
          <div class="col-sm-12">Delivery Location: <input id="to" class="form-control"  readonly style="background-color:white;"/></div>
        </div>
        </p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Courier Guy Locations</th>
            </tr>
            </thead>
            <tbody id="t_points"></tbody>
        </table>
    </div>
    <div id="map" class="col col-sm-9 full"></div>
</div>

