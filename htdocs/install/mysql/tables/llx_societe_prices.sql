-- ========================================================================
-- Copyright (C) 2007 Rodolphe Quiedeville <rodolphe@quiedeville.org>
--
-- This program is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 2 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program. If not, see <http://www.gnu.org/licenses/>.
--
-- $Id: llx_societe_prices.sql,v 1.3 2011/08/03 01:25:38 eldy Exp $
-- ========================================================================

create table llx_societe_prices
(
  rowid              integer AUTO_INCREMENT PRIMARY KEY,
  fk_soc             integer   DEFAULT 0,
  tms                timestamp NOT NULL, 
  datec	             datetime,
  fk_user_author     integer,
  price_level        tinyint   DEFAULT 1
)ENGINE=innodb;