-- SQL Script to Update Plant Image Paths
-- This script updates the image column for each plant in the database
-- Run this script against your local greenthumb_nursery database

UPDATE plants SET image = 'plants/monstera.jpg' WHERE name = 'Monstera Deliciosa';
UPDATE plants SET image = 'plants/Snake.jpeg' WHERE name = 'Snake Plant (Sansevieria)';
UPDATE plants SET image = 'plants/Fiddle.jpg' WHERE name = 'Fiddle Leaf Fig';
UPDATE plants SET image = 'plants/JadePlantSucculents.jpg' WHERE name = 'Jade Plant';
UPDATE plants SET image = 'plants/PeaceLily.jpg' WHERE name = 'Peace Lily';
UPDATE plants SET image = 'plants/Pothos.jpg' WHERE name = 'Pothos Golden';
UPDATE plants SET image = 'plants/Echeveria.jpeg' WHERE name = 'Echeveria Elegans';
UPDATE plants SET image = 'plants/African.jpeg' WHERE name = 'African Violet';
UPDATE plants SET image = 'plants/Basil.jpg' WHERE name = 'Basil';
UPDATE plants SET image = 'plants/Rosemary.jpeg' WHERE name = 'Rosemary';
UPDATE plants SET image = 'plants/Hostas.jpeg' WHERE name = 'Hostas';
UPDATE plants SET image = 'plants/Lavender.jpg' WHERE name = 'Lavender';

-- Verify the updates
SELECT name, image FROM plants WHERE image IS NOT NULL;

