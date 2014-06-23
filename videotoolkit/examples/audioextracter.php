<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {
    	//$vid = $_POST['filepath'];
    	
    	$video = new Video($example_video_path);
    //	echo $vid = 'http://10.90.90.157/video/Videos/big_buck_bunny_multi.ogg';
    	
    //	$parser = new MediaParser();
	//	$data = $parser->getFileInformation($_POST['filepath']);
    //	print_r($data);
    	
    	//$video = new Video($vid);              //$example_video_path
    
    	//echo $example_video_path;

		$process = $video->extractAudio()->save('./output/'.$_POST['name'], null, Media::OVERWRITE_EXISTING);	
	 // $process = $video->extractVideo()->save('./output/big_buck_bunny.mp4');

		$output = $process->getOutput();
		exit(json_encode(array('success' => true)));    
        
    }
    catch(FfmpegProcessOutputException $e)
    {
        exit(json_encode(array('success' => false))); 
    }
    catch(Exception $e)
    {
    	exit(json_encode(array('success' => false)));
    }

