<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Photogrammetry Web App Upload Images</title>
    <link href="style.css?version=1" rel="stylesheet" type="text/css">
    <script src="jquery-3.3.1.min.js"></script>

    <script type="text/javascript">

        $(function(){

            $("#file").blur(function(){

              //  var files = $('#file')[0].files[0];
                var upfiles = $('#file')[0].files;
                for(var file_no=0; file_no<upfiles.length; file_no++)
                {
                    files = upfiles[file_no];
        
               
                   var message =  files.name ;

                var node = document.createElement("li");                 // Create a <li> node
                var textnode = document.createTextNode(message);         // Create a text node
                node.appendChild(textnode);                              // Append the text to <li>
                document.getElementById("content").appendChild(node);   
                }                                                         // Append <li> to <ul> with id="myList"

            });
            $("#but_upload").click(function(){

                var fail = 0;
                var fd = new FormData();

              //  var files = $('#file')[0].files[0];
                var upfiles = $('#file')[0].files;
                console.log(upfiles);
                for(var file_no=0; file_no<upfiles.length; file_no++)
                {
                    console.log(upfiles[file_no]);
                    files = upfiles[file_no];
                
                fd.append('file',files);
                $.ajax({
                    url:'upload.php',
                    type:'post',
                    data:fd,
                    contentType: false,
                    processData: false,
                    success:function(response){
                        if(response != 0){
                            console.log(response);
                            $("#img").attr("src",response);

                            $('.preview img').show();
                        }else{
                            fail = 1;
                            alert('File not uploaded');
                        }
                        }

                        });
                  
                delete fd['file'];
                }
                if(fail===0){
                    console.log("all pass");

                    $("#but_upload")[0].style.color = "#343f3e";
                    $("#but_upload")[0].style.backgroundColor = "#dcedff";
                }
            })
            });


    </script>

</head>
<body>
    <header>
    
      <div class="container">
            <a href="index.php"><h1>Photo<br/>Grammetry</h1></a>
            <div class="box">
                <div>List of files selected for upload</div>
                <ol id="content">
                    
                </ol>

            </div>
        </div>


    </header>

        <div class="container">
            <div class="filechoose">
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <div >
                        <input type="file" id="file" name="file" multiple>
                    </div>
                    <div>
                        <input type="button" class="button" value="Upload" id="but_upload">
                    </div>
                </form>
            </div>
            <div class="inst">
                <span>INSTRUCTIONS:<br/></span>
                <ul>
                    <li>Object must be completely in focus in all the images</li>
                    <li>At least 80% overlap should be there between every pair of consecutive images</li>
                    <li>Object being captured should be properly lit / illuminated and not under very bright lights</li>
                    <li>Distance between camera and the object should remain uniform for all photos in a sequence</li>
                    <li>Images should be clicked in either clockwise/anticlockwise manner throughout the process</li>
                    <li>Photos should be sequentially named i.e. in the same order in which they were clicked</li>
                    <li>All the photos should be either JPG, PNG or JPEG format</li>
                    <li>Even zipped files should contain above mentioned file formats</li>
                </ul>
            </div>
    </div></div>
</body>
</html>