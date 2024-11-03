<?php

namespace app\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }
    public function rules()
    {
        return [
            [['desc_category', 'is_active'], 'required'],
            [['is_active', 'user_id', 'parent_id', 'id_bancos', 'id_clientes', 'id_produtos_clientes'], 'integer'],
            [['descricao_detalhada', 'historico_alteracoes', 'regras_auto_categorizacao'], 'string'],
            [['limite_orcamento'], 'number'],
            [['desc_category', 'hexcolor_category', 'icone', 'tags'], 'string', 'max' => 100],
            [['tipo'], 'in', 'range' => ['gasto', 'receita', 'ambos']],
            [['compartilhavel'], 'boolean'],
            [['regras_auto_categorizacao'], 'safe'],
            ['regras_auto_categorizacao', 'validateJsonFormat'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_category' => Yii::t('app', 'ID'),
            'desc_category' => Yii::t('app', 'Description'),
            'hexcolor_category' => Yii::t('app', 'Color'),
            'icone' => Yii::t('app', 'Icon'),
            'descricao_detalhada' => Yii::t('app', 'Detailed Description'),
            'tipo' => Yii::t('app', 'Type'),
            'limite_orcamento' => Yii::t('app', 'Budget Limit'),
            'compartilhavel' => Yii::t('app', 'Shareable'),
            'tags' => Yii::t('app', 'Tags'),
            'regras_auto_categorizacao' => Yii::t('app', 'Auto-Categorization Rules'),
            'parent_id' => Yii::t('app', 'Parent Category'),
            'id_bancos' => Yii::t('app', 'Bank'),
            'id_clientes' => Yii::t('app', 'Client'),
            'id_produtos_clientes' => Yii::t('app', 'Product/Client'),
            'historico_alteracoes' => Yii::t('app', 'Change History'),
            'is_active' => Yii::t('app', 'Active'),
        ];
    }

    public function validateJsonFormat($attribute, $params)
    {
        if (!empty($this->$attribute)) {
            json_decode($this->$attribute);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError($attribute, Yii::t('app', 'The field must contain valid JSON.'));
            }
        }
    }

    public function getCashbooks()
    {
        return $this->hasMany(Cashbook::className(), ['category_id' => 'id_category']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getBanco()
    {
        return $this->hasOne(Bancos::className(), ['id_bancos' => 'id_bancos']);
    }

    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'id_clientes']);
    }

    public function getProdutoCliente()
    {
        return $this->hasOne(ProdutosClientes::className(), ['id' => 'id_produtos_clientes']);
    }

    public static function getHierarchy()
    {
        $options = [];

        $parents = self::find()->where(['parent_id' => null, 'user_id' => Yii::$app->user->identity->id, 'is_active' => 1])->all();
        foreach ($parents as $id_category => $p) {
            $children = self::find()->where("parent_id=:parent_id", [":parent_id" => $p->id_category])->all();
            $child_options = [];
            foreach ($children as $child) {
                $child_options[$child->id_category] = $child->desc_category;
            }
            $options[$p->desc_category] = $child_options;
        }
        return $options;
    }

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id_category' => 'parent_id']);
    }
}