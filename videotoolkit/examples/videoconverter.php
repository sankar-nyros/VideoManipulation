<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {
        $vid = $_POST['filepath'];
		
		//$video = new Video($vid);
		
		$video = new Video($example_video_path);
		
		$parser = new MediaParser();
		$data = $parser->getFileInformation($example_video_path);
		
		$video_codec = $data['video']['codec']['name'];
		$video_rate  = $data['video']['frames']['rate'];
		$audio_codec = $data['audio']['codec']['name'];
		
		
		if (strpos($_POST['name'],'3gp') !== false) 
		{
    	  	$multi_output = new MultiOutput();
			$threegp_output = './output/'.$_POST['name'];
			$format = Format::getFormatFor($threegp_output, $config, 'VideoFormat');
			$format->setVideoDimensions((int)$_POST['width'],(int)$_POST['height'])
				   ->setVideoFrameRate($video_rate);
				   
			$multi_output->addOutput($threegp_output, $format);
			
			$output = $video->save($multi_output, null, Media::OVERWRITE_EXISTING);	
		}
		else
		{
			$output_format = new VideoFormat();
			$output_format->setVideoDimensions((int)$_POST['width'],(int)$_POST['height'])
						  ->setVideoFrameRate($video_rate)
						  ->setVideoCodec('libx264')
						  ->setAudioCodec('mp3');
			$video->save('./output/'.$_POST['name'], $output_format, Media::OVERWRITE_EXISTING);
		}
		
		echo(json_encode(array('success' => true)));
    }
    catch(FfmpegProcessOutputException $e)
    {
		exit(json_encode(array('success' => false,'Message' => $e->getMessage()))); 
    }
    catch(Exception $e)
    {
    	exit(json_encode(array('success' => false,'Message' => $e->getMessage()))); 
    }

