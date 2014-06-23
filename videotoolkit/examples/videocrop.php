<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {
  
				
		//$video  = new Video($_POST['filepath']);
		
		$video = new Video($example_video_path);
		$process = $video->getProcess();

		$width = $_POST['width'];
		$height = $_POST['height'];
		$rw = $_POST['x'];$rh = $_POST['y'];

		//ffmpeg -i in.mp4 -filter:v "crop=640:480:100:100" out.mp4
		
		//$process->addCommand('-acodec','mp3');
	    //$process->addPreInputCommand('-vcodec',$argument=true,$allow_command_repetition=true);
	
		//$process->addCommand('-vcodec',true,true);
		//$process->addCommand('-vcodec', $argument='libx264', $allow_command_repetition=true);
		
		$process->addCommand('-filter:v','crop='.$width.':'.$height.':'.$rw.':'.$rh);
		
		$video->save('./output/'.$_POST['name'], null, Media::OVERWRITE_EXISTING);
		// Trace::vars($process->getExecutedCommand());

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

