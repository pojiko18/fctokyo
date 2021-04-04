<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
    <script src="jquery.exif.js"></script>
</head>

<body>
    <input type="file" id="file1" />
    <script>
    $('#file1').change(function() {
        $(this).fileExif(function(exif) {
            if (!exif) {
                console.log("exif情報なし");
                return;
            }
            if (!exif.GPSLatitude) {
                console.log("GPS情報なし");
                return;
            }
            var lat = exif.GPSLatitude[0] + (exif.GPSLatitude[1] / 60) + (exif.GPSLatitude[2] / 3600);
            var lng = exif.GPSLongitude[0] + (exif.GPSLongitude[1] / 60) + (exif.GPSLongitude[2] /
            3600);
            console.log({
                lat,
                lng
            }); // google maps とかで使える形式
        });
    });
    </script>
</body>

</html>