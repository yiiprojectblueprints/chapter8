<?php

/**
 * This is the model class for table "content".
 *
 * The followings are the available columns in table 'content':
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property integer $published
 * @property integer $author_id
 * @property integer $category_id
 * @property string $slug
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Categories $category
 * @property Users $author
 */
class Content extends CMSSlugActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'content';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, body, slug, category_id', 'required'),
            array('published, author_id, category_id, created, updated', 'numerical', 'integerOnly'=>true),
            array('title, slug', 'length', 'max'=>255),
            array('slug', 'validateSlug'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, body, published, author_id, category_id, slug, created, updated', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'published' => 'Published',
            'author_id' => 'Author',
            'category_id' => 'Category',
            'slug' => 'Slug',
            'created' => 'Created',
            'updated' => 'Updated',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('body',$this->body,true);
        $criteria->compare('published',$this->published);
        $criteria->compare('author_id',$this->author_id);
        $criteria->compare('category_id',$this->category_id);
        $criteria->compare('slug',$this->slug,true);
        $criteria->compare('created',$this->created);
        $criteria->compare('updated',$this->updated);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 5,
                'pageVar'=>'page'
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Content the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}