<?php namespace ChannelData\Model;

use ChannelData\Base\BaseModel;

class ChannelField extends BaseModel {

	protected $table = 'channel_fields';

	protected $idField = 'field_id';
	
	protected $fillable = array(
		'site_id',
		'group_id',
		'field_name',
		'field_label',
		'field_instructions',
		'field_type',
		'field_list_items',
		'field_pre_populate',
		'field_pre_channel_id',
		'field_pre_field_id',
		'field_ta_rows',
		'field_maxl',
		'field_required',
		'field_text_direction',
		'field_search',
		'field_is_hidden',
		'field_fmt',
		'field_show_fmt',
		'field_order',
		'field_content_type',
		'field_settings'
	);

	protected $guarded = array('field_id');

	public function toArray()
	{
		$return = parent::toArray();
		$return['field_settings'] = unserialize(base64_decode($return['field_settings']));

		return $return;
	}

	public function label()
	{
		return $this->field_label;
	}

	public function name()
	{
		return $this->field_name;
	}

	public static function findByEntry($entry)
	{
		$channel = Channel::findByEntry($entry);

		if(!$channel)
		{
			return NULL;
		}

		return ChannelField::findByGroup($channel->field_group);
	}

	public static function findByChannel($channel)
	{
		$channel = Channel::find($channel);

		if(!$channel)
		{
			return NULL;
		}

		return self::findByGroup($channel->field_group);
	}

	public static function findByName($name)
	{
		return self::query()->where('field_name', $name)->get()->first();
	}

	public static function findByGroup($groupId)
	{
		return self::query()->where('group_id', $groupId)->result();
	}
}