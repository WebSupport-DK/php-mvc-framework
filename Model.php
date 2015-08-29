<?php

namespace thom855j\mvc ;

use thom855j\sql\DB ;

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

    public static
            function load( $storage = null )
    {
        if ( !isset( self::$_instance ) )
        {
            self::$_instance = new Model( $storage ) ;
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
            function get( $where = array( array() ) ,
                          $paging = array( 'start' , 'end' , 'max' ) ,
                          $options = array() )
    {

        if ( !empty( $paging ) )
        {
            return $this->paging( $paging[ 'start' ] , $paging[ 'end' ] ,
                                  $paging[ 'max' ] , $where , $options ) ;
        }
        else
        {
            $this->storage->select( array( $this->rows ) , $this->table ,
                                      $where , $options ) ;
            return $this->storage->results() ;
        }
    }

    // get last ind fro SQL INSERT
    public
            function getLastInsertId()
    {
        return $this->storage->lastInsertId() ;
    }

    public
            function paging( $start , $end , $max , $where = array( array() ) ,
                             $options = null )
    {

        $page    = isset( $start ) ? ( int ) $start : 1 ;
        $perPage = isset( $end ) && $end <= $max ? ( int ) $end : 5 ;

        $pages = ($page > 1) ? ($page * $perPage) - $perPage : 0 ;

        $this->total = (ceil( $this->count()[ 0 ]->Total / $perPage )) ;

        $this->storage->select( array( $this->rows ) , $this->table , $where ,
                                  array( 'ORDER BY ID' => 'DESC' , 'LIMIT' => "$pages,$perPage" ) ) ;


        return $this->storage->results() ;
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
