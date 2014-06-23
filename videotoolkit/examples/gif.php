<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {
  
		//$video  = new Video($_POST['filepath']);
		
		$config->convert = '/usr/bin/convert';
		$config->gif_transcoder = 'gifsicle';

		$start = (int)$_POST['start'];
		$end = (int)$_POST['end'];
		$output_path = './output/'.$_POST['name'];
	
		$output_format = Format::getFormatFor($output_path, $config, 'ImageFormat');
		$output_format->setVideoFrameRate(20)
					  ->setVideoDimensions(640,480);


		$video = new Video($example_video_path,$config);
		
		$process = $video->extractSegment(new Timecode($start), new Timecode($end))
				         ->save($output_path, $output_format, Media::OVERWRITE_EXISTING);	

		$output = $process->getOutput();
		echo(json_encode(array('success' => true)));
    }
    catch(FfmpegProcessOutputException $e)
    {
		echo(json_encode(array('success' => false,'Message' => $e->getMessage()))); 
    }
    catch(Exception $e)
    {
        echo(json_encode(array('success' => false,'Message' => $e->getMessage()))); 
    }

