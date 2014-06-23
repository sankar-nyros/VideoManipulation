<?php

    namespace PHPVideoToolkit;

    include_once './includes/bootstrap.php';
  
    try
    {
    	$vid = $_POST['filepath'];
    	//echo $example_video_path;
    	$video = new Video($example_video_path);              //$example_video_path
    
        $process = $video->extractSegment(new Timecode((int)$_POST['start']), new Timecode((int)$_POST['end']))
                ->save('./output/'.$_POST['name'], null, Media::OVERWRITE_EXISTING);

		//echo "1";
		exit(json_encode(array('success' => true)));

      /*  echo '<h1>Executed Command</h1>';
        Trace::vars($process->getExecutedCommand());
        echo '<hr /><h1>FFmpeg Process Messages</h1>';
        Trace::vars($process->getMessages());
        echo '<hr /><h1>Buffer Output</h1>';
        Trace::vars($process->getBuffer(true));
        echo '<hr /><h1>Resulting Output</h1>';
        Trace::vars($process->getOutput()->getMediaPath());
      */
        
    }
    catch(FfmpegProcessOutputException $e)
    {
        //echo "0";
        exit(json_encode(array('success' => false)));
        /*
        echo '<h1>Error</h1>';
        Trace::vars($e);

        $process = $video->getProcess();
        if($process->isCompleted())
        {
            echo '<hr /><h2>Executed Command</h2>';
            Trace::vars($process->getExecutedCommand());
            echo '<hr /><h2>FFmpeg Process Messages</h2>';
            Trace::vars($process->getMessages());
            echo '<hr /><h2>Buffer Output</h2>';
            Trace::vars($process->getBuffer(true));
        }
        */
    }
    catch(Exception $e)
    {
    	//echo "0";
    	exit(json_encode(array('success' => false)));
    	/*
        echo '<h1>Error</h1>';
        Trace::vars($e->getMessage());
        echo '<h2>Exception</h2>';
        Trace::vars($e);
        */
    }

