<?php
class Model_Db_Table_Product extends System_Db_Table
{
    protected $_name = 'product';
/**
 * update or insert product to DB
 * 
 * @param Model_Product $productModel
 * 
 */
    public function create($productModel)
    {        
        $id             = $productModel->id ;
        $name           = $productModel->name ;
        $description    = $productModel->description;
        $img            = $productModel->img;
        $price          = $productModel->price;
        $total          = $productModel->total;
        
        if($id !=NULL)
            {
            $sth = $this->_connection->prepare('UPDATE ' . $this->_name . ' SET name=?,description=?,img=?,price=?,total=? where id='.$id);    
            }
            else 
            {
            $sth = $this->_connection->prepare('INSERT INTO ' . $this->_name . ' (name,description,img,price,total) VALUES (?,?,?,?,?)');            
            }
        
        
        $result = $sth->execute(array($name,$description,$img,$price,$total));       
    }
    /**
     * 
     * @param str $name
     * @param int $id
     * @return PDOStatement
     */
    public function selectByName($name,$id=NULL)
    {
        $name = trim($name);
        $id   = trim($id);
        
        $requestParams = array($name);
        
        $sql = 'select * from ' . $this->_name . ' where name = ?';
        if($id != NULL) {
            $sql .= 'AND id != ?';
            array_push($requestParams, $id);
        }
        
        /**
         * @var PDOStatement $sth 
         */
        $sth = $this->_connection->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);        
                
        return $result;
    } 
 }