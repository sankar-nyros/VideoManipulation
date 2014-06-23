<?php
    
    /**
     * This file is part of the PHP Video Toolkit v2 package.
     *
     * @author Gowri Sankar 
     *
     */
     
    namespace PHPVideoToolkit;

    /**
     * This class provides generic data parsing for the output from FFmpeg from specific
     * media files. Parts of the code borrow heavily from Jorrit Schippers version of 
     * PHPVideoToolkit v 0.1.9.
     *
     */
    class VideoManipulation
    {
        
        public function snapshot($video,$time_snap,$output) 
		{ 	
		 	try
			{
				$vid = $video;              	//Video file path
				$time = (int)$time_snap;		//Time in seconds to take snapshot
				$output_image_name = $output;	//Output image name
		  
				$video = new Video($vid);              
	
				$process = $video->extractFrame(new Timecode($time))->save('./output/'.$output_image_name, null, Media::OVERWRITE_EXISTING);	

				$output = $process->getOutput();
	
				return true; 
			
			}
			catch(FfmpegProcessOutputException $e)
			{
				return false;
			}
			catch(Exception $e)
			{
				return false;
			}			
		}
		
		
		public function trim($input_video,$start_time,$end_time,$output)
		{
			try
			{
				$video = new Video($input_video);              
				$start = (int)$start_time;
				$end = (int)$end_time;
				
		    	$process = $video->extractSegment(new Timecode($start), new Timecode($end))
		            ->save('./output/'.$output, null, Media::OVERWRITE_EXISTING);

				$output = $process->getOutput();
	
				return true; 
			}
			catch(FfmpegProcessOutputException $e)
			{
				return false;
			}
			catch(Exception $e)
			{
				return false;
			}	
		
		}
		
		
		public function crop($input_video,$width,$height,$x,$y,$output)
		{
		
			try
			{
				$video  = new Video($input_video);
				$process = $video->getProcess();

				$w = (int)$width;
				$h = (int)$height;
				$rw = (int)$x;
				$rh = (int)$y;
		
				$process->addCommand('-filter:v','crop='.$w.':'.$h.':'.$rw.':'.$rh);
		
				$video->save('./output/'.$output, null, Media::OVERWRITE_EXISTING);
				$output = $process->getOutput();
				return true; 
			}
			catch(FfmpegProcessOutputException $e)
			{
				return false;
			}
			catch(Exception $e)
			{
				return false;
			}	
		}
		
		
		public function audio_extract($input_video,$output)
		{
			try
			{
				$video = new Video($input_video);       
				$process = $video->extractAudio()->save('./output/'.$output, null, Media::OVERWRITE_EXISTING);
				$output = $process->getOutput();
				return true; 
			}
			catch(FfmpegProcessOutputException $e)
			{
				return false;
			}
			catch(Exception $e)
			{
				return false;
			}				
		}
		
		
		public function video_resizer_format($input_video,$width,$height,$output)
		{
			try
			{

				$video = new Video($input_video);
				
				$parser = new MediaParser();
				$data = $parser->getFileInformation($input_video);

				$video_codec = $data['video']['codec']['name'];
				$video_rate  = $data['video']['frames']['rate'];
				$audio_codec = $data['audio']['codec']['name'];


				if (strpos($input_video,'3gp') !== false) 
				{
				  	$multi_output = new MultiOutput();
					$threegp_output = './output/'.$output;
					$format = Format::getFormatFor($threegp_output, $config, 'VideoFormat');
					$format->setVideoDimensions((int)$width,(int)$height)
						   ->setVideoFrameRate($video_rate);
						   
					$multi_output->addOutput($threegp_output, $format);

					$output = $video->save($multi_output, null, Media::OVERWRITE_EXISTING);	
				}
				else
				{
					$output_format = new VideoFormat();
					$output_format->setVideoDimensions((int)$width,(int)$height)
								  ->setVideoFrameRate($video_rate)
								  ->setVideoCodec('libx264')
								  ->setAudioCodec('mp3');
					$video->save('./output/'.$output, $output_format, Media::OVERWRITE_EXISTING);
				}

				return true;
			}
			catch(FfmpegProcessOutputException $e)
			{
				return false;
			}
			catch(Exception $e)
			{
				return false;
			}

		}
		 
    }

