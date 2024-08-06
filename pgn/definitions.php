<?php

namespace chess\pgn;

const NO_COLOR = " ";
const WHITE = "w";
const BLACK = "b";

const EMPTY_PIECE = " ";
const PAWN = "P";
const KNIGHT = "N";
const BISHOP = "B";
const ROOK = "R";
const QUEEN = "Q";
const KING = "K";

const NO_CASTLING = "-";
const WHITE_KING_SIDE_CASTLING = "K";
const WHITE_QUEEN_SIDE_CASTLING = "Q";
const BLACK_KING_SIDE_CASTLING = "k";
const BLACK_QUEEN_SIDE_CASTLING = "q";

const NO_EN_PASSANT = "-";

class WhitePiece {
    const PAWN = "P";
    const KNIGHT = "N";
    const BISHOP = "B";
    const ROOK = "R";
    const QUEEN = "Q";
    const KING = "K";
}

class BlackPiece {
    const PAWN = "p";
    const KNIGHT = "n";
    const BISHOP = "b";
    const ROOK = "r";
    const QUEEN = "q";
    const KING = "k";
}

function getPieceColor($piece) {
    if (ctype_upper($piece)) {
        return WHITE;
    }
    if (ctype_lower($piece)) {
        return BLACK;
    }
    return NO_COLOR;
}

function getPieceType($piece) {
    return strtoupper($piece);
}

function row($field) {
    return 8 - intval($field[1]);
}

function column($field) {
    return ord($field[0]) - ord('a');
}

function toIndex($field) {
    return row($field) * 8 + column($field);
}

function toField($index) {
    return chr($index % 8 + ord('a')) . (8 - intval($index / 8));
}

function offset($field, $offset) {
    $newRow = chr(ord($field[1]) + $offset[1]);
    $newColumn = chr(ord($field[0]) + $offset[0]);
    return $newColumn . $newRow;
}

function isValidField($field) {
    $column = column($field);
    $row = row($field);
    return $column >= 0 && $column < 8 && $row >= 0 && $row < 8;
}

function opponent($color) {
    return $color === WHITE ? BLACK : WHITE;
}