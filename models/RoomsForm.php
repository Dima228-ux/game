<?php


namespace app\models;

use Yii;

/**
 * Class RoomsForm
 * @package app\models
 */
class RoomsForm extends Model
{
    public $id;
   public $name;
   public $count_users;
   public $is_free;

    /**
     *  constructor.
     *
     * @param Room $room
     */

    public function __construct(Room $room)
    {
        parent::__construct($room);
        $this->setAttributes($this->_entity->getAttributes(), false);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'length' => [3, 30]],
            [['name'], 'unique', 'targetAttribute' => 'name', 'targetClass' => Room::class,
                'message' => 'This {attribute} is already exists',
                'when' => function ($model) {
                    $count = Room::find()->where(['name' => $model->name])->count();

                    if ($count > 1 && !$this->isNewRecord) {
                        return true;
                    } elseif (Room::find()->where(['name' => $model->name])->exists() && $this->isNewRecord) {
                        return true;
                    }
                    return false;
                }
            ],
        ];
    }

    public function save(){
        if (!$this->validate()) {
            return false;
        }

        /** @var Room $room */
        $room = $this->_entity;
        $room->name=$this->name;
        $room->count_users=1;
        $room->is_free=true;

        if($room->save()){
            $model=new SessionGameForm(new SessionGame());
            $model->id_room=$room->id;
            $model->id_user1=Yii::$app->user->id;
            if ($model->save()){
                return true;
            }
            return  false;
        }

        return false;
    }

}