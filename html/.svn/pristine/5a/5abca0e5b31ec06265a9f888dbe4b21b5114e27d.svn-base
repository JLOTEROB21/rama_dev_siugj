<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

document.open();
var data = { command:"getReport", idReporte: findGetParameter("idreporte"), database: "latis" }
data = JSON.stringify(data);
//document.write(data);
data = encodeURIComponent(data);

$.ajax({
method: "POST",
url: "handlerlatis.php",
data: data
})
.done(function( response ) {
   
    document.write(response);
   
});
document.close();
</SCRIPT>
