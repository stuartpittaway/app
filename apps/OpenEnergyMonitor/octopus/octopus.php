<?php
    global $path, $session, $v;
?>
<link href="<?php echo $path; ?>Modules/app/Views/css/config.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="<?php echo $path; ?>Modules/app/Views/css/light.css?v=<?php echo $v; ?>" rel="stylesheet">

<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat&amp;lang=en" />
<script type="text/javascript" src="<?php echo $path; ?>Modules/app/Lib/config.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo $path; ?>Modules/app/Lib/feed.js?v=<?php echo $v; ?>"></script>

<script type="text/javascript" src="<?php echo $path; ?>Modules/app/Lib/vis.helper.js?v=<?php echo $v; ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.7.0/echarts.min.js" integrity="sha256-eKrx6Ly6b0Rscx/PSm52rJsvK76RJyv18Toswq+OLSs=" crossorigin="anonymous"></script>

<style>
.electric-title {
    font-weight:bold;
    font-size:22px;
    color:#44b3e2;
}

.power-value {
    font-weight:bold;
    font-size:52px;
    color:#44b3e2;
    line-height: 1.1;
}

.halfhour-value {
    font-weight:bold;
    font-size:42px;
    color:#44b3e2;
    line-height: 1.1;
}

.units {
    font-size:75%;
}

.block-bound {
  background-color:rgb(68,179,226);
}

.bluenav-active {
  background-color:rgba(255,255,255,0.2);
}

.time-select {
  width:165px; 
  margin:4px 5px 0px 0px; 
  float:right; 
  background-color: #44b3e2;
}

@media(max-width: 610px) {
  .time-select {
    margin:4px 0px 0px 5px; 
    float:none;
  }
  #history-title {display:none;}
}
</style>
<div style="font-family: Montserrat, Veranda, sans-serif;">
<div id="app-block" style="display:none">
  <div id="octopus-realtime" class="col1"><div class="col1-inner">
    <div class="block-bound">
      <div class="bluenav openconfig"><i class="icon-wrench icon-white"></i></div>
      <!--<div class="bluenav viewcostenergy">VIEW COST</div>-->
      <div class="bluenav cost">Cost</div>
      <div class="bluenav energy bluenav-active">Energy</div>
      <div id="app-title" class="block-title">OCTOPUS AGILE</div>
    </div>

    <div style="background-color:#fff; color:#333; padding:10px;">
      <table style="width:100%">
        <tr>
          <td style="width:40%">
              <div class="electric-title">IMPORT NOW</div>
              <div class="power-value"><span id="power_now">0</span></div>
          </td>

          <td style="text-align:center" class="last_halfhour_stats">
              <div class="electric-title">CURRENT PRICE</div>
              <div class="power-value"><span id="unit_price"></span></div>
          </td>

          <td style="text-align:right" class="last_halfhour_stats">
              <div class="electric-title">CURRENT HALF HOUR</div>
              <div class="halfhour-value"><span id="kwh_halfhour"></span> <span id="cost_halfhour"></span></div>
          </td>

        </tr>
      </table>
    </div>

  </div></div>
  <div class="col1"><div class="col1-inner">

    <div class="block-bound" style="min-height:36px">

      <div class="graph-navigation">
        <span class="bluenav" id="fastright" >>></span>
        <span class="bluenav" id="fastleft" ><<</span>
        <span class="bluenav" id="right" >></span>
        <span class="bluenav" id="left" ><</span>
        <!--<span class="bluenav" id="zoomout" >-</span>-->
        <!--<span class="bluenav" id="zoomin" >+</span>
        <span class="bluenav time" time='1440' title='Previous 60 days'>60d</span>
        <span class="bluenav time" time='720' title='Previous 30 days'>30d</span>
        <span class="bluenav time" time='168' title='Previous 7 days'>7d</span>
        <span class="bluenav time" time='24' title='Previous 24 hours'>1d</span>
        <span class="bluenav time" time='12' title='Previous 12 hours'>12h</span>
        <span class="bluenav time" time='M' title='Since midnight 1st of month'>Month</span>
        <span class="bluenav time" time='W' title='Since midnight Sunday'>Week</span>
        <span class="bluenav time" time='Y' title='Yesterday'>Yesterday</span>
        <span class="bluenav time" time='T' title='Today since midnight'>Today</span>-->
        <select class="time-select">
            <option value='1440'>Previous 60 days</option>
            <option value='720'>Previous 30 days</option>
            <option value='168'>Previous 7 days</option>
            <option value='24'>Previous 24 hours</option>
            <option value='12>Previous 12 hours</option>
            <option value='M'>Since midnight 1st of month</option>
            <option value='W'>Since midnight Sunday</option>
            <option value='Y'>Yesterday</option>
            <option value='T' selected>Today since midnight</option>
        </select>
      </div>

      <div id="history-title" class="block-title">HISTORY</div>

    </div>

    <div style="background-color:rgba(68,179,226,0.1); padding:10px;">
      <div id="placeholder_bound" style="width:100%; height:600px;">
        <div id="placeholder" style="height:600px"></div>
      </div>
    </div>

    <div class="power-graph-footer" style="background-color:#f0f0f0; color:#333; display:none">
      <div style="padding:20px;">
      <table style="width:100%" class="table">
      <tr><th></th><th>Energy</th><th>Cost / Value</th><th>Unit price</th></tr>
      <tbody id="octopus_totals"></tbody>
      </table>
    </div>
  </div></div>
</div>
</div>




<section id="app-setup" class="hide pb-3">
    <!-- instructions and settings -->
    <div class="px-3">
        <div class="row-fluid">
            <div class="span9 appconfig-description">
                <div class="appconfig-description-inner text-light">
                    <h2 class="appconfig-title text-primary"><?php echo _('Octopus Agile'); ?></h2>
                    <p class="lead">Explore Octopus Agile tariff costs over time.</p>
                    <p><strong class="text-white">Auto configure:</strong> This app can auto-configure connecting to emoncms feeds with the names shown on the right, alternatively feeds can be selected by clicking on the edit button.</p>
                    <p><strong class="text-white">Import & Import kWh</strong> The standard naming for electricity imported from the grid in a household without solar PV is 'use' and 'use_kwh', this app expects 'import' and 'import_kwh' in order to provide compatibility with the Solar PV option as well. Select relevant house consumption feeds using the dropdown feed selectors as required. Feeds 'use_kwh' and 'solar_kwh' are optional.</p>
                    <p><strong class="text-white">Cumulative kWh</strong> feeds can be generated from power feeds with the power_to_kwh input processor. To create cumulative kWh feeds from historic power data try the postprocess module.</p>
                    <p><strong class="text-white">Optional: Octopus Outgoing</strong> Include total house consumption (use_kwh) and solar PV (solar_kwh) feeds to explore octopus outgoing feed-in-tariff potential.</p>
                    <img src="../Modules/app/images/agile_app.png" class="d-none d-sm-inline-block">
                </div>
            </div>
            <div class="span3 app-config pt-3"></div>
        </div>
    </div>
</section>

<div class="ajax-loader"><img src="<?php echo $path; ?>Modules/app/images/ajax-loader.gif"/></div>

<script>

// ----------------------------------------------------------------------
// Globals
// ----------------------------------------------------------------------
var apikey = "<?php print $apikey; ?>";
var sessionwrite = <?php echo $session['write']; ?>;

apikeystr = "";
if (apikey!="") apikeystr = "&apikey="+apikey;

var view_mode = "energy";


// ----------------------------------------------------------------------
// Display
// ----------------------------------------------------------------------
$("body").css('background-color','WhiteSmoke');
$(window).ready(function(){
    //$("#footer").css('background-color','#181818');
    //$("#footer").css('color','#999');
});

if (!sessionwrite) $(".openconfig").hide();

// ----------------------------------------------------------------------
// Configuration
// ----------------------------------------------------------------------
config.app = {
    "title":{"type":"value", "default":"OCTOPUS AGILE", "name": "Title", "description":"Optional title for app"},
    "import":{"optional":true, "type":"feed", "autoname":"import", "engine":"5"},
    "import_kwh":{"type":"feed", "autoname":"import_kwh", "engine":5},
    "use_kwh":{"optional":true, "type":"feed", "autoname":"use_kwh", "engine":5},
    "solar_kwh":{"optional":true, "type":"feed", "autoname":"solar_kwh", "engine":5},
    "region":{"type":"select", "name":"Select region:", "default":"D_Merseyside_and_Northern_Wales", "options":["A_Eastern_England","B_East_Midlands","C_London","E_West_Midlands","D_Merseyside_and_Northern_Wales","F_North_Eastern_England","G_North_Western_England","H_Southern_England","J_South_Eastern_England","K_Southern_Wales","L_South_Western_England","M_Yorkshire","N_Southern_Scotland","P_Northern_Scotland"]}
};
config.name = "<?php echo $name; ?>";
config.db = <?php echo json_encode($config); ?>;
config.feeds = feed.list();

config.initapp = function(){init()};
config.showapp = function(){show()};
config.hideapp = function(){hide()};

var regions_import = {
  "A_Eastern_England":396124,
  "B_East_Midlands":396125,
  "C_London":396126,
  "E_West_Midlands":396127,
  "D_Merseyside_and_Northern_Wales":396105,
  "F_North_Eastern_England":396128,
  "G_North_Western_England":396129,
  "H_Southern_England":396138,
  "J_South_Eastern_England":396139,
  "K_Southern_Wales":396140,
  "L_South_Western_England":396141,
  "M_Yorkshire":396142,
  "N_Southern_Scotland":396143,
  "P_Northern_Scotland":396144
}

var regions_outgoing = {
  "A_Eastern_England":399374,
  "B_East_Midlands":399361,
  "C_London":399362,
  "E_West_Midlands":399363,
  "D_Merseyside_and_Northern_Wales":399364,
  "F_North_Eastern_England":399365,
  "G_North_Western_England":399366,
  "H_Southern_England":399367,
  "J_South_Eastern_England":399368,
  "K_Southern_Wales":399369,
  "L_South_Western_England":399370,
  "M_Yorkshire":399371,
  "N_Southern_Scotland":399372,
  "P_Northern_Scotland":399373
}

// ----------------------------------------------------------------------
// APPLICATION
// ----------------------------------------------------------------------
var feeds = {};
var meta = {};
var data = {};
var graph_series = [];
var previousPoint = false;
var viewmode = "graph";
var viewcostenergy = "energy";
var panning = false;
var period_text = "month";
var period_average = 0;
var comparison_heating = false;
var comparison_transport = false;
var flot_font_size = 12;
var updaterinst = false;
var this_halfhour_index = -1;
// disable x axis limit
view.limit_x = false;
var solarpv_mode = false;

config.init();

function init()
{

}

function show() {
    $("body").css('background-color','WhiteSmoke');
    $("#app-title").html(config.app.title.value);

    // Quick translation of feed ids
    feeds = {};
    for (var key in config.app) {
        if (config.app[key].value) feeds[key] = config.feedsbyid[config.app[key].value];
    }

    resize();

    setPeriod('T');
    graph_load();
    graph_draw();

    updater();
    updaterinst = setInterval(updater,5000);
    $(".ajax-loader").hide();
}

function setPeriod(period) {
    switch (period) {
    case 'T':
        //Today
        var d = new Date();
        d.setHours(0,0,0,0);
        view.start = d.getTime();
        d.setHours(24,0,0,0);
        view.end = d.getTime();
        //view.timewindow(3600000);
        break;
    case 'Y':
        //Yesterday
        var d = new Date();
        d.setHours(0,0,0,0);
        view.end =  d.getTime();
        d.setHours(-24);
        view.start = d.getTime();
        //view.timewindow(3600000);
        break;
    case 'W':
        //Week
        var d = new Date();
        view.end = d.getTime();
        d.setHours(0,0,0,0);
        d.setHours(-24 * d.getDay());
        view.start = d.getTime();
        // view.timewindow(3600000);
        break;
    case 'M':
        // Month
        var d = new Date();
        view.end = d.getTime();
        d.setHours(0,0,0,0);
        d.setHours(-24 * (d.getDate()-1));
        view.start = d.getTime();
        // view.timewindow(3600000);
        break;
    case '12':
    case '24':
    case '168':
    case '720':
    case '1440':
        var timeWindow = (3600000*period);
        view.end = (new Date()).getTime();
        view.start = view.end - timeWindow;

        if (period<=24) {
            view.end += 3600*4*1000; // show 4h of forecast for short time ranges
        }
        // view.timewindow(timeWindow);
        break;
	  default:
		    alert('Invalid time period');
		    break;
    }
}

function hide() {
    clearInterval(updaterinst);
}

function updater()
{
    feed.listbyidasync(function(result){
        if (result === null) { return; }

        for (var key in config.app) {
            if (config.app[key].value) feeds[key] = result[config.app[key].value];
        }

        if (feeds["import"]!=undefined) {
            if (viewcostenergy=="energy") {
                if (feeds["import"].value<10000) {
                    $("#power_now").html(Math.round(feeds["import"].value)+"<span class='units'>W</span>");
                } else {
                    $("#power_now").html((feeds["import"].value*0.001).toFixed(1)+"<span class='units'>kW</span>");
                }
            } else {
                $("#power_now").html(config.app.currency.value+(feeds["import"].value*1*config.app.unitcost.value*0.001).toFixed(3)+"<span class='units'>/hr</span>");
            }
        }
    });
}

// -------------------------------------------------------------------------------
// EVENTS
// -------------------------------------------------------------------------------
// The buttons for these graph events are hidden when in historic mode 
// The events are loaded at the start here and dont need to be unbinded and binded again.
//$("#zoomout").click(function () {view.zoomout(); graph_load(); graph_draw(); });
//$("#zoomin").click(function () {view.zoomin(); graph_load(); graph_draw(); });
$('#right').click(function () {view.pan_speed = 0.5; view.panright(); graph_load(); graph_draw(); });
$('#left').click(function () {view.pan_speed = 0.5; view.panleft(); graph_load(); graph_draw(); });
$('#fastright').click(function () {view.pan_speed = 1.0; view.panright(); graph_load(); graph_draw(); });
$('#fastleft').click(function () {view.pan_speed = 1.0; view.panleft(); graph_load(); graph_draw(); });


$('.time').click(function () {
    setPeriod($(this).attr("time"));
    graph_load();
    graph_draw();
});

$('.time-select').change(function () {
    setPeriod($(this).val());
    graph_load();
    graph_draw();
});

$("#advanced-toggle").click(function () {
    var mode = $(this).html();
    if (mode=="SHOW DETAIL") {
        $("#advanced-block").show();
        $(this).html("HIDE DETAIL");
    } else {
        $("#advanced-block").hide();
        $(this).html("SHOW DETAIL");
    }
});

$('#placeholder').bind("plothover", function (event, pos, item) {
    if (item) {
        var z = item.dataIndex;

        if (previousPoint != item.datapoint) {
            previousPoint = item.datapoint;

            $("#tooltip").remove();
            var itemTime = item.datapoint[0];
            var itemValue = item.datapoint[1];

            var d = new Date(itemTime);
            var days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
            var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
            var hours = d.getHours();
            if (hours<10) hours = "0"+hours;
            var minutes = d.getMinutes();
            if (minutes<10) minutes = "0"+minutes;
            var seconds = d.getSeconds();
            if (seconds<10) seconds = "0"+seconds;

            var date = hours+":"+minutes+":"+seconds+", "+days[d.getDay()]+" "+months[d.getMonth()]+" "+d.getDate();

            var text = item.series.label+"<br>"+date+"<br>";
            if (item.series.label=='Agile' || item.series.label=='Outgoing') {
                text += (itemValue*1.05).toFixed(2)+" p/kWh (inc VAT)";
            } else {
                if (view_mode=="energy") text += (itemValue).toFixed(3)+" kWh";
                if (view_mode=="cost") text += (itemValue*100).toFixed(1)+"p";
            }
            tooltip(item.pageX, item.pageY, text, "#fff");
        }
    } else $("#tooltip").remove();
});

$('#placeholder').bind("plotselected", function (event, ranges) {
    var start = ranges.xaxis.from;
    var end = ranges.xaxis.to;
    panning = true;
    view.start = start; view.end = end;
    graph_load();
    graph_draw();
    setTimeout(function() { panning = false; }, 100);
});

$(".viewcostenergy").click(function(){
    var view = $(this).html();
    if (view=="VIEW COST") {
        $(this).html("VIEW ENERGY");
        viewcostenergy = "cost";
    } else {
        $(this).html("VIEW COST");
        viewcostenergy = "energy";
    }
});

$(".energy").click(function() {
    view_mode = "energy";
    graph_draw()
    $(this).addClass("bluenav-active");
    $(".cost").removeClass("bluenav-active");
});

$(".cost").click(function() {
    view_mode = "cost";
    graph_draw()
    $(this).addClass("bluenav-active");
    $(".energy").removeClass("bluenav-active");
});

// -------------------------------------------------------------------------------
// FUNCTIONS
// -------------------------------------------------------------------------------
// - graph_load
// - graph_draw
// - resize

function graph_load()
{
    $(".power-graph-footer").show();
    var interval = 1800;
    var intervalms = interval * 1000;
    view.start = Math.ceil(view.start/intervalms)*intervalms;
    view.end = Math.ceil(view.end/intervalms)*intervalms;

    if (feeds["use_kwh"]!=undefined && feeds["solar_kwh"]!=undefined) solarpv_mode = true;

    var import_kwh = feed.getdata(feeds["import_kwh"].id,view.start,view.end,interval,0,0);

    var use_kwh = [];
    if (solarpv_mode) use_kwh = feed.getdata(feeds["use_kwh"].id,view.start,view.end,interval,0,0);
    var solar_kwh = [];
    if (solarpv_mode) solar_kwh = feed.getdata(feeds["solar_kwh"].id,view.start,view.end,interval,0,0);
    data = {};

    data["agile"] = []
    data["outgoing"] = []
    if (config.app.region!=undefined && regions_import[config.app.region.value]!=undefined) {
        data["agile"] = feed.getdataremote(regions_import[config.app.region.value],view.start,view.end,interval);
        data["outgoing"] = feed.getdataremote(regions_outgoing[config.app.region.value],view.start,view.end,interval);
    }
    // Invert export tariff
    for (var z in data["outgoing"]) data["outgoing"][z][1] *= -1;

    data["use"] = [];
    data["import"] = [];
    data["import_cost"] = [];
    data["export"] = [];
    data["export_cost"] = [];
    data["solar_used"] = []
    data["solar_used_cost"] = [];

    var total_cost_import = 0
    var total_kwh_import = 0
    var total_cost_export = 0
    var total_kwh_export = 0
    var total_cost_solar_used = 0
    var total_kwh_solar_used = 0

    this_halfhour_index = -1;
    // Add last half hour
    var this_halfhour = Math.floor((new Date()).getTime()/1800000)*1800000
    for (var z=1; z<import_kwh.length; z++) {
        if (import_kwh[z][0]==this_halfhour) {
            import_kwh[z+1] = [this_halfhour+1800000,feeds["import_kwh"].value]
            this_halfhour_index = z
            if (solarpv_mode) {
                use_kwh[z+1] = [this_halfhour+1800000,feeds["use_kwh"].value]
                solar_kwh[z+1] = [this_halfhour+1800000,feeds["solar_kwh"].value]
            }
            break;
        }
    }

    if (import_kwh.length>1) {
        for (var z=1; z<import_kwh.length; z++) {
            let time = import_kwh[z-1][0];

            if (solarpv_mode) {
                // ----------------------------------------------------
                // Solar PV agile outgoing
                // ----------------------------------------------------
                // calculate half hour kwh
                let kwh_use = 0;
                let kwh_import = 0;
                let kwh_solar = 0;

                if (use_kwh[z]!=undefined && use_kwh[z-1]!=undefined) kwh_use = (use_kwh[z][1]-use_kwh[z-1][1]);
                if (import_kwh[z]!=undefined && import_kwh[z-1]!=undefined) kwh_import = (import_kwh[z][1]-import_kwh[z-1][1]);
                if (solar_kwh[z]!=undefined && solar_kwh[z-1]!=undefined) kwh_solar = (solar_kwh[z][1]-solar_kwh[z-1][1]);

                // limits
                if (kwh_use<0.0) kwh_use = 0.0;
                if (kwh_import<0.0) kwh_import = 0.0;
                if (kwh_solar<0.0) kwh_solar = 0.0;

                // calc export & self consumption
                let kwh_solar_used = kwh_use - kwh_import;
                let kwh_export = kwh_solar - kwh_solar_used;

                // half hourly datasets for graph
                data["use"].push([time,kwh_use]);
                data["import"].push([time,kwh_import]);
                data["export"].push([time,(kwh_export*-1)]);
                data["solar_used"].push([time,kwh_solar_used]);

                // energy totals
                total_kwh_import += kwh_import
                total_kwh_export += kwh_export
                total_kwh_solar_used += kwh_solar_used

                // costs
                let cost_import = data.agile[z-1][1]*0.01;
                let cost_export = data.outgoing[z-1][1]*0.01*-1;

                // half hourly datasets for graph
                data["import_cost"].push([time,kwh_import*cost_import]);
                data["export_cost"].push([time,kwh_export*cost_export*-1]);
                data["solar_used_cost"].push([time,kwh_solar_used*cost_import]);

                // cost totals
                total_cost_import += kwh_import*cost_import
                total_cost_export += kwh_export*cost_export
                total_cost_solar_used += kwh_solar_used*cost_import
            } else {
                // ----------------------------------------------------
                // Import mode only
                // ----------------------------------------------------
                let kwh_import = 0;
                if (import_kwh[z]!=undefined && import_kwh[z-1]!=undefined) kwh_import = (import_kwh[z][1]-import_kwh[z-1][1]);
                if (kwh_import<0.0) kwh_import = 0.0;
                data["import"].push([time,kwh_import]);
                total_kwh_import += kwh_import
                let cost_import = data.agile[z-1][1]*0.01;
                data["import_cost"].push([time,kwh_import*cost_import]);
                total_cost_import += kwh_import*cost_import
            }
        }
    }

    var unit_cost_import = (total_cost_import/total_kwh_import);

    var out = "";
    out += "<tr>";
    out += "<td>Import</td>";
    out += "<td>"+total_kwh_import.toFixed(1)+" kWh</td>";
    out += "<td>£"+total_cost_import.toFixed(2)+"</td>";
    out += "<td>"+(unit_cost_import*100*1.05).toFixed(1)+"p/kWh (inc VAT)</td>";
    out += "</tr>";

    if (solarpv_mode) {
        var unit_cost_export = (total_cost_export/total_kwh_export);
        out += "<tr>";
        out += "<td>Export</td>";
        out += "<td>"+total_kwh_export.toFixed(1)+" kWh</td>";
        out += "<td>£"+total_cost_export.toFixed(2)+"</td>";
        out += "<td>"+(unit_cost_export*100*1.05).toFixed(1)+"p/kWh (inc VAT)</td>";
        out += "</tr>";

        var unit_cost_solar_used = (total_cost_solar_used/total_kwh_solar_used);
        out += "<tr>";
        out += "<td>Solar self consumption</td>";
        out += "<td>"+total_kwh_solar_used.toFixed(1)+" kWh</td>";
        out += "<td>£"+total_cost_solar_used.toFixed(2)+"</td>";
        out += "<td>"+(unit_cost_solar_used*100*1.05).toFixed(1)+"p/kWh (inc VAT)</td>";
        out += "</tr>";

        var unit_cost_solar_combined = ((total_cost_solar_used+total_cost_export)/(total_kwh_solar_used+total_kwh_export));
        out += "<tr>";
        out += "<td>Solar + Export</td>";
        out += "<td>"+(total_kwh_solar_used+total_kwh_export).toFixed(1)+" kWh</td>";
        out += "<td>£"+(total_cost_solar_used+total_cost_export).toFixed(2)+"</td>";
        out += "<td>"+(unit_cost_solar_combined*100*1.05).toFixed(1)+"p/kWh (inc VAT)</td>";
        out += "</tr>";
    }

    $("#octopus_totals").html(out);
}

var myChart;

function graph_draw()
{
    if (this_halfhour_index!=-1) {
        let kwh_last_halfhour = data["import"][this_halfhour_index][1];
        $("#kwh_halfhour").html(kwh_last_halfhour.toFixed(2)+"<span class='units'>kWh</span>");

        let cost_last_halfhour = data["import_cost"][this_halfhour_index][1]*100;
        $("#cost_halfhour").html("("+cost_last_halfhour.toFixed(2)+"<span class='units'>p</span>)");

	//1.05 to add on 5% VAT
        let unit_price = data["agile"][this_halfhour_index][1]*1.05;
        $("#unit_price").html(unit_price.toFixed(2)+"<span class='units'>p</span>");

        $(".last_halfhour_stats").show();
    } else {
        $(".last_halfhour_stats").hide();
    }

    // based on prepared DOM, initialize echarts instance
    myChart = echarts.init(document.getElementById('placeholder'));

  // specify chart configuration item and data
        var option = {
	tooltip : { trigger: 'axis', position: function(pt) { return [pt[0],'10%'];} },
toolbox: {
feature:{ dataZoon: { yAxisIndex: 'none'}
}},

dataZoom: [
{ type: 'inside', start:0, end:100, minValueSpan:1800, maxValueSpan:3600 * 24 * 1000 * 7 }
,{start:0, end:10}
],

            legend: {type:'plain', padding:4, itemGap:5 },
            xAxis: [
		{type: 'time',minInterval:1800,boundaryGap:false,
axisLine: {onZero: true}, splitLine: {show: false}, splitArea: {show: false}}
            ],
            yAxis: [
	{show:true, position:'left', type:'value', name:'Energy'},
	{show:true, position:'right', type:'value', name:'Octopus Tariff'}
],
            series: [
	 {name:"Used Solar", itemStyle:{color:"#bec745"}, type:'bar', yAxisIndex:0, stack:'a' }
	,{name:"Import", itemStyle:{color:"#44b3e2"}, type:'bar', yAxisIndex:0, stack:'a'}
	,{name:"Export", itemStyle:{color:"#dccc1f"}, type:'bar', yAxisIndex:0, stack:'a'}
	,{name:"Agile Tariff", itemStyle:{color:"#fb1a80"}, type:'line', yAxisIndex:1}
	,{name:"Outgoing", itemStyle:{color:"#941afb"}, type:'line', yAxisIndex:1}]
        };

if (view_mode=="energy") {
        option.series[0].data=data["solar_used"];
        option.series[1].data=data["import"];
        option.series[2].data=data["export"];
} else if (view_mode=="cost") {
        option.series[0].data=data["solar_used_cost"];
        option.series[1].data=data["import_cost"];
        option.series[2].data=data["export_cost"];
}

option.series[3].data=data["agile"];
option.series[4].data=data["outgoing"];

// Remove anything solar related if needed
if (solarpv_mode==false) {
 option.remove(series[0]);
 option.remove(series[2]);
 option.remove(series[4]);
}

myChart.setOption(option);
}

// -------------------------------------------------------------------------------
// RESIZE
// -------------------------------------------------------------------------------
function resize() {
    var top_offset = 0;
    var placeholder_bound = $('#placeholder_bound');
    var placeholder = $('#placeholder');

    var window_height = $(window).height();
    var topblock = $("#octopus-realtime").height();

    var width = placeholder_bound.width();
    var height = window_height - topblock - 250;
    if (height<250) height = 250;

    placeholder.width(width);
    placeholder_bound.height(height);
    placeholder.height(height-top_offset);

    if (width<=500) {
        $(".electric-title").css("font-size","14px");
        $(".power-value").css("font-size","36px");
        $(".halfhour-value").css("font-size","26px");
    } else if (width<=724) {
        $(".electric-title").css("font-size","16px");
        $(".power-value").css("font-size","50px");
        $(".halfhour-value").css("font-size","40px");
    } else {
        $(".electric-title").css("font-size","20px");
        $(".power-value").css("font-size","50px");
        $(".halfhour-value").css("font-size","40px");
    }

    if (myChart) { myChart.resize(); }
}

$(function() {
    $(document).on('window.resized hidden.sidebar.collapse shown.sidebar.collapse', function(){
        var window_width = $(this).width();

        flot_font_size = 12;
        if (window_width<450) flot_font_size = 10;

        resize();

//        graph_draw();
    })
})

// ----------------------------------------------------------------------
// App log
// ----------------------------------------------------------------------
function app_log (level, message) {
    if (level=="ERROR") alert(level+": "+message);
    console.log(level+": "+message);
}
</script>
