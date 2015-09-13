<?php

namespace thom855j\PHPMvcFramework;

use thom855j\PHPScrud\DB ;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract
        class Model
{

    // object instance
    protected static
            $_instance = null ;
    private
            $storage ,
            $table ,
            $columns ,
            $rows ,
            $total ;

    public
            function __construct( $storage )
    {
        $this->storage = $storage ;
        $this->table   = '' ;
        $this->rows    = '' ;
        $this->columns = array() ;
    }

    // init a singleton object of class
    public static
            function load( $storage = null )
    {
        if ( !isset( self::$_instance ) )
        {
            // absctract models cannot be instanciated. But yours can!
            //self::$_instance = new Model( $storage ) ;
        }
        return self::$_instance ;
    }

    public
            function setModel( $name , $value )
    {
        $this->$name = $value ;
    }

    public
            function search( $query )
    {
        return $this->storage->search( $this->table , $this->rows , $query ,
                                       array( $this->rows ) ) ;
    }

    // create 
    public
            function create( $fields = array() )
    {
        return $this->storage->insert( $this->table , $fields ) ;
    }

    // read
    public
            function read( $paging = null , $where = array( array() ) )
    {
        if ( !empty( $paging ) )
        {
            return $this->paging( $paging[ 'start' ] , $paging[ 'end' ] ,
                                  $paging[ 'max' ] , $where ) ;
        }
        else
        {
            $this->storage->select( array( $this->rows ) , $this->table , $where ) ;
            return $this->storage->results() ;
        }
    }

    // get page by specific search 
    public
            function get($where, $paging = array(), $options = array())
    {

        if (!empty($paging))
        {
            return $this->paging($paging['start'], $paging['end'], $paging['max'], $where, $options);
        }
        else
        {
            $this->_db->select(array($this->_rows), $this->_table, $where, $options);
            return $this->_db->results();
        }
    }

    // get last ind fro SQL INSERT
    public
            function getLastInsertId()
    {
        return $this->storage->lastInsertId() ;
    }

    public
            function paging($start, $end, $max)
    {

        $page    = isset($start) ? (int) $start : 1;
        $this->_perPage = isset($end) && $end <= $max ? (int) $end : 5;

        $this->_pages = ($page > 1) ? ($page *   $this->_perPage ) -   $this->_perPage  : 0;

        $this->_total = (ceil($this->count()[0]->Total /   $this->_perPage ));

    }

    public
            function count()
    {
        $this->storage->select( array( "count(*) AS Total" ) , $this->table ,
                                null ) ;
        return $this->storage->results() ;
    }

    public
            function total()
    {
        return $this->total ;
    }

    // update page by id
    public
            function update( $fields = array() , $ID = null )
    {
        return $this->storage->update( $this->table , 'ID' , $ID , $fields ) ;
    }

    // delete
    public
            function delete( $where = array( array() ) )
    {
        return $this->storage->delete( $this->table , $where ) ;
    }

}
