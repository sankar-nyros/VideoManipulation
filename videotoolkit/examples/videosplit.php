<?php

    namespace PHPVideoToolkit;
	use ZipArchive;

    include_once './includes/bootstrap.php';
  
    try
    {
    	//$vid = $_POST['filepath'];
    
    	$parser = new MediaParser();
		$data = $parser->getFileInformation($example_video_path);
	
		$split_time = $_POST['splits'];
    	$name = $_POST['name'];
    	
    	$timecode = new Timecode('00:00:01.00', Timecode::INPUT_FORMAT_TIMECODE);
    	$timecode->setTimecode($data['duration']);
		$tot_duration = floor($timecode->total_seconds); 
    	
    	if($tot_duration % $split_time == 0)
    	{
    		$no_parts = $tot_duration / $split_time;
    	}
    	else
    	{
			$no_parts = floor($tot_duration / $split_time);
			$last_video_start = $no_parts * $split_time + 1;
			$last_video_end = $tot_duration-($no_parts * $split_time);
		}
		
		for($i=1;$i<=$no_parts;$i++)
		{
			if($i == 1)
			{
				$video = new Video($example_video_path);              //$example_video_path
				$process = $video->getProcess();
				$process->addCommand('-ss',1);
        		$process->addCommand('-t',$split_time);
				$video->save('./output/'.$name.'_'.$i.'.mp4', null, Media::OVERWRITE_EXISTING);	
				$output = $process->getOutput();
			}
			else
			{
				$start = ($i-1) * $split_time + 1;
				$end =  $start + $split_time - 1 ;
				$video = new Video($example_video_path);              //$example_video_path
				$process = $video->getProcess();
				$process->addCommand('-ss',$start);
        		$process->addCommand('-t',$split_time);
				$video->save('./output/'.$name.'_'.$i.'.mp4', null, Media::OVERWRITE_EXISTING);
				$output = $process->getOutput();
			}
		}
		
		$video = new Video($example_video_path);              //$example_video_path
		$process = $video->getProcess();
		$process->addCommand('-ss',$last_video_start);
		$process->addCommand('-t',$last_video_end);
		$video->save('./output/'.$name.'_'.($no_parts+1).'.mp4', null, Media::OVERWRITE_EXISTING);
		$output = $process->getOutput();
		

		if(extension_loaded('zip'))
		{ 
			// Checking ZIP extension is available
			
				$zip = new \ZipArchive(); 
				$dname = time();
				$zip_name = "./output/".$dname.".zip"; // Zip name

				if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
				{ 
					echo "Sorry ZIP creation failed at this time";
				}
				for($i=1;$i<=$no_parts;$i++)
				{

					$zip->addFile('./output/'.$name.'_'.$i.'.mp4'); // Adding files into zip
				}
				$zip->close();
		}
		else
		{
			exit(json_encode(array('success' => true,'msg' => 'ZIP extension failed')));       
		}
		exit(json_encode(array('success' => true,'msg' => $dname)));       
    }
    catch(FfmpegProcessOutputException $e)
    {
    	 Trace::vars($e->getMessage());
         exit(json_encode(array('success' => false))); 
    }
    catch(Exception $e)
    {
    	Trace::vars($e->getMessage());
    	exit(json_encode(array('success' => false)));
    }

