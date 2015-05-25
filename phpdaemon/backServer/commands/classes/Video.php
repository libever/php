<?php

if(!defined('Video')) {

	/**
	 * 解决转化格式的问题
	 * @author istrone
	 */
	class Video {

		const VideoStatusUnimproved = -1;
		const VideoStatusAuditting = 0;						//正在审核
		const VideoStatusImproved = 1;
		const VideoStatusFormatIlegal = -2;
		const VideoStatusConverting = -3;

		/**
		 * @param string $srcFile  源文件
		 * @param string $desFile  目标文件
		 * @param string $uniqeid 唯一值ID
		 * $srcFile="",$desFile="",$uniqeid=""	参数集合
		 */
		public function convert_to_flv( $params = array() ){
			extract($params);
			$ffmpegPath = back_config_item('ffmpeg');
			$flvtool2Path = back_config_item('flvtool2');
			$ffmpegObj = new ffmpeg_movie($srcFile);
			$srcWidth = $this->makeMultipleTwo($ffmpegObj->getFrameWidth());
			$srcHeight = $this->makeMultipleTwo($ffmpegObj->getFrameHeight());
			$srcAB = intval($ffmpegObj->getAudioBitRate()/1000);
			$srcAR = $ffmpegObj->getAudioSampleRate();
			$cmd=$ffmpegPath . " -i " . $srcFile . " -ar " . $srcAR . " -ab " . $srcAB ." -f flv -s " . $srcWidth . "x" . $srcHeight . "  " . $desFile . "";
			$cmd.=' 1>'.back_config_item('flv_log_path').$uniqueid.'_log'.'.txt 2>&1';
			$status=1;$out="";
			exec($cmd,$out,$status);
			if($status == 0) {
				unlink($srcFile);			//转化成功状态不用变
			}else {
				BackServer::addLog('error', '视频格式不合法啦！');
				$video = $this->getVideo($uniqueid);
				if($video) {
					$id = $video['authorid'];
					$message = '您于'.$video['addtime'].'上传的'.$video['title'].'格式不合法！';
					$notice = new Notice();
					$notice->AddNotice($id, $message);
				}else {
					BackServer::addLog('error', '该视频的用户ID找不到！');
				}
				$this->changeState(array('uniqueid'=>$uniqueid, 'status'=>self::VideoStatusFormatIlegal));		//视频格式不合法
			}
			return $status==0;
		}

		/**
		 * 创建缩略图
		 * @param string	$flv flv文件的完整路径
		 * @param string	 $sl  缩略图的完成路径
		 * $flv,$sl
		 */
		public function create_thumbnail($params = array() ){
			extract($params);
			$ffmpegPath = back_config_item('ffmpeg');
			$cmd=$ffmpegPath." -i $flv -ss 1 -vframes 1 -r 1 -ac 1 -ab 2 -s 160*120 -f image2 $sl";
			$status=1;
			$out="";
			exec($cmd,$out,$status);
			return $status==0;
		}


		private function makeMultipleTwo ($value)
		{
			$sType = gettype($value/2);
			if($sType == "integer")
			{
				return $value;
			} else {
				return ($value-1);
			}
		}

		/**
		 * 改变视频的状态
		 * 并且给用户发送转化成功的通知
		 * $id,$uid,$status
		 */
		public function changeState($params = array() ) {
			extract($params);
			if(!isset($status) || $status == '' ) 
				$status = self::VideoStatusConverting;
			$db = BackServer::GetDB();
			$db->Update('cms_zdpost',array('status'=>$status),'uniqueid = '.$id);
		}

		
		private function getVideo($uniqeid) {
			$db = BackServer::GetDB();
			$item =	$db->getItem('cms_zdpost','uniqueid =	\'' . $id . '\'');
			return $item;
		}
	}
	
	define('Video', 'Video');
}