FROM php:8.1-apache as base

RUN a2enmod rewrite
