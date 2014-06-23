<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {		
		//$video  = new Video($_POST['filepath']);
		
		$video = new Video($example_video_path);
		$process = $video->getProcess();
		
		$name = $_POST['name'];

		//ffmpeg -i /var/www/video/Videos/big_buck_bunny.webm -vcodec flv -f flv -r 29.97 -aspect 16:9 -b 300k -g 160 -cmp dct -subcmp dct -mbd 2 -flags +aic+cbp+mv0+mv4 -trellis 1 -ac 1 -ar 22050 -ab 56k -s 640x360 -vf "movie=/var/www/video/Images/veera.jpg [wm]; [in][wm] overlay=main_w-overlay_w-10:main_h-overlay_h-10 [out]" /var/www/video/videotoolkit/examples/output/outputvideo.mp4


		$process->addCommand('-vf','movie=/var/www/video/videotoolkit/examples/watermark.jpg [wm]; [in][wm] overlay=main_w-overlay_w-10:main_h-overlay_h-10 [out]');
	
		$video->save('./output/'.$name, null, Media::OVERWRITE_EXISTING);

		echo(json_encode(array('success' => true)));
    }
    catch(FfmpegProcessOutputException $e)
    {
    	 Trace::vars($e->getMessage());
		echo(json_encode(array('success' => false)));
    }
    catch(Exception $e)
    {
        
        Trace::vars($e->getMessage());
        echo(json_encode(array('success' => false)));
    }

