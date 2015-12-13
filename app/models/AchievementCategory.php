<?php

class AchievementCategory extends BaseModel {
	public function getName( $lang = null ) {
		return $this->localized( 'name', $lang );
	}

	private $d = array();
	public function getData( $lang = null ) {
		if ( !array_key_exists( $lang, $this->d ) ) {
			$this->d[ $lang ] = json_decode( 
				str_replace( array( '<br>' ),
				             array( '\n'   ),
				             $this->localized( 'data', $lang )));
		}
		return $this->d[ $lang ];
	}

	public function getIconUrl( $size = 64 ) {
		$size = intval( $size );
		if( !in_array( $size, array( 16, 32, 64) )) {
			if( $size <= 16 ) { 
				$size = 16;
			} elseif ( $size <= 32 ) {
				$size = 32;
			} else {
				$size = 64;
			}
		}

		return Helper::cdn( 'icons/' . $this->signature . '/' . $this->file_id . '-' . $size . 'px.png', $this->file_id );
	}

	public function getIcon( $size = 64 ) {
		$out = '<img src="' . $this->getIconUrl( $size ) . '"';
		$out .= ' width="' . $size . '"';
		$out .= ' height="' . $size . '"';
		$out .= ' alt=""';
		$out .= ' crossorigin="anonymous"';
		if( $size <= 32 ) {
			$out .= ' srcset="' . $this->getIconUrl( $size ) . ' 1x, ' . $this->getIconUrl( $size * 2 ) . ' 2x"';
		}
		$out .= '>';

		return $out;
	}

	public function achievements() {
		return $this->hasMany( Achievement::class, 'achievement_category_id', 'id' );
	}
}
