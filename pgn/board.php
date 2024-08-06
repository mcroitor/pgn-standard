<?php

namespace chess\pgn;

class Board {
    public const EMPTY_FEN = "8/8/8/8/8/8/8/8 w KQkq - 0 1";
    public const INITIAL_FEN = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";

    private $board = [];
    private $fen = self::EMPTY_FEN;
    private $turn = "w";
    private $castling = "KQkq";
    private $enPassant = "-";
    private $halfMoveClock = 0;
    private $fullMoveNumber = 1;

    public function __construct($fen = self::EMPTY_FEN) {
        $this->fen = $fen;
        $this->parseFen();
    }

    private function parseFen() {
        $parts = explode(" ", $this->fen);
        $this->turn = $parts[1];
        $this->castling = $parts[2];
        $this->enPassant = $parts[3];
        $this->halfMoveClock = $parts[4];
        $this->fullMoveNumber = $parts[5];

        $this->board = $this->parseBoard($parts[0]);
    }

    private function parseBoard($fen) {
        $board = [];
        $ranks = explode("/", $fen);
        foreach ($ranks as $rank) {
            $board = array_merge($board, $this->parseRank($rank));
        }
        return $board;
    }

    private function parseRank($rank) {
        $files = str_split($rank);
        $result = [];
        foreach ($files as $file) {
            if (is_numeric($file)) {
                $empty = array_fill(0, intval($file), \chess\pgn\EMPTY_PIECE);
                $result = array_merge($result, $empty);
            } else {
                $result[] = $file;
            }
        }
        return $result;
    }

    public function getBoard() {
        return $this->board;
    }

    public function getTurn() {
        return $this->turn;
    }

    public function getCastling() {
        return $this->castling;
    }

    public function getEnPassant() {
        return $this->enPassant;
    }

    public function getHalfMoveClock() {
        return $this->halfMoveClock;
    }

    public function getFullMoveNumber() {
        return $this->fullMoveNumber;
    }

    public function __toString() {
        return $this->fen;
    }

    public function toFen() {
        return $this->fen;
    }

    public function setPiece($square, $piece) {
        $index = toIndex($square);
        $this->board[$index] = $piece;

        $this->fen = $this->generateFen();
    }

    private function generateFen() {
        $fen = "";
        $empty = 0;
        for ($i = 0; $i < 64; $i++) {
            if ($this->board[$i] === \chess\pgn\EMPTY_PIECE) {
                $empty++;
            } else {
                if ($empty > 0) {
                    $fen .= $empty;
                    $empty = 0;
                }
                $fen .= $this->board[$i];
            }
            if (($i + 1) % 8 === 0) {
                if ($empty > 0) {
                    $fen .= $empty;
                    $empty = 0;
                }
                if ($i < 63) {
                    $fen .= "/";
                }
            }
        }
        $fen .= " " . $this->turn .
            " " . $this->castling .
            " " . $this->enPassant .
            " " . $this->halfMoveClock .
            " " . $this->fullMoveNumber;
        return $fen;
    }

    public function getPiece($square) {
        $index = toIndex($square);
        $piece = $this->board[$index];
        return $piece;
    }

    public function move($from, $to) {
        $piece = $this->getPiece($from);
        if($piece == \chess\pgn\EMPTY_PIECE) {
            return false;
        }
        if(getPieceColor($piece) != $this->turn) {
            return false;
        }
        if(getPieceColor($this->getPiece($to)) == getPieceColor($piece)) {
            return false;
        }
        $this->setPiece($from, \chess\pgn\EMPTY_PIECE);
        $this->setPiece($to, $piece);
        $this->turn = $this->turn == \chess\pgn\WHITE ? \chess\pgn\BLACK : \chess\pgn\WHITE;
        if(getPieceType($piece) == \chess\pgn\PAWN) {
            $this->halfMoveClock = 0;
        } else {
            $this->halfMoveClock++;
        }
        if($this->turn == \chess\pgn\WHITE) {
            $this->fullMoveNumber++;
        }
        // TODO: implement castling, en passant, promotion
        $this->fen = $this->generateFen();
    }

    public function getPieceMoves($index) {
        $piece = $this->board[$index];
        $pieceType = getPieceType($piece);
        $field = toField($index);
        $moves = [];

        switch ($pieceType) {
            case \chess\pgn\PAWN:
                $moves = $this->getPawnMoves($field);
                break;
            case \chess\pgn\KNIGHT:
                $moves = $this->getKnightMoves($field);
                break;
            case \chess\pgn\BISHOP:
                $moves = $this->getBishopMoves($field);
                break;
            case \chess\pgn\ROOK:
                $moves = $this->getRookMoves($field);
                break;
            case \chess\pgn\QUEEN:
                $moves = $this->getQueenMoves($field);
                break;
            case \chess\pgn\KING:
                $moves = $this->getKingMoves($field);
                break;
        }
        return $moves;
    }

    public function getKingAttacks($field){
        $attacks = [];
        $directions = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1], [0, 1],
            [1, -1], [1, 0], [1, 1]
        ];
        foreach ($directions as $direction) {
            $target = offset($field, $direction);
            if (isValidField($target)) {
                $attacks[] = $target;
            }
        }
        return $attacks;
    }

    public function getKingMoves($field) {
        $color = getPieceColor($this->getPiece($field));
        $attacks = $this->getKingAttacks($field);
        $moves = [];
        foreach ($attacks as $attack) {
            $oppositeAttacks = $this->getAllAttacks(opponent($color));
            if(getPieceColor($this->getPiece($attack)) != $color &&
                !in_array($attack, $oppositeAttacks)) {
                $moves[] = $field . $attack;
            }
        }
        return $moves;
    }

    public function getQueenAttacks($field) {
        return array_merge(
            $this->getRookAttacks($field),
            $this->getBishopAttacks($field)
        );
    }

    public function getQueenMoves($field) {
        return array_merge(
            $this->getRookMoves($field),
            $this->getBishopMoves($field)
        );
    }

    public function getRookAttacks($field) {
        $attacks = [];
        $directions = [
            [-1, 0], [0, -1], [0, 1], [1, 0]
        ];
        foreach ($directions as $direction) {
            $target = offset($field, $direction);
            while (isValidField($target)) {
                $attacks[] = $target;
                if (getPieceColor($this->getPiece($target)) != NO_COLOR) {
                    break;
                }
                $target = offset($target, $direction);
            }
        }
        return $attacks;
    }
    
    public function getRookMoves($field) {
        $color = getPieceColor($this->getPiece($field));
        $attacks = $this->getRookAttacks($field);
        $moves = [];
        foreach ($attacks as $attack) {
            if(getPieceColor($this->getPiece($attack)) == $color) {
                continue;
            }
            $moves[] = $field . $attack;
        }
        return $moves;
    }

    public function getBishopAttacks($field) {
        $attacks = [];
        $directions = [
            [-1, -1], [-1, 1], [1, -1], [1, 1]
        ];
        foreach ($directions as $direction) {
            $target = offset($field, $direction);
            while (isValidField($target)) {
                $attacks[] = $target;
                if (getPieceColor($this->getPiece($target)) != NO_COLOR) {
                    break;
                }
                $target = offset($target, $direction);
            }
        }
        return $attacks;
    }

    public function getBishopMoves($field) {
        $color = getPieceColor($this->getPiece($field));
        $attacks = $this->getBishopAttacks($field);
        $moves = [];
        foreach ($attacks as $attack) {
            if(getPieceColor($this->getPiece($attack)) == $color) {
                continue;
            }
            $moves[] = $field . $attack;
        }
        return $moves;
    }

    public function getKnightAttacks($field) {
        $pieceColor = getPieceColor($this->getPiece($field));
        $attacks = [];
        $directions = [
            [-2, -1], [-2, 1], [-1, -2], [-1, 2],
            [1, -2], [1, 2], [2, -1], [2, 1]
        ];
        foreach ($directions as $direction) {
            $target = offset($field, $direction);
            if (isValidField($target)) {
                $attacks[] = $target;
            }
        }
        return $attacks;
    }

    public function getKnightMoves($field) {
        $color = getPieceColor($this->getPiece($field));
        $attacks = $this->getKnightAttacks($field);
        $moves = [];
        foreach ($attacks as $attack) {
            if(getPieceColor($this->getPiece($attack)) == $color) {
                continue;
            }
            $moves[] = $field . $attack;
        }
        return $moves;
    }

    public function getPawnAttacks($field) {
        $pieceColor = getPieceColor($this->getPiece($field));
        $attacks = [];
        $direction = $pieceColor == \chess\pgn\WHITE ? [0, 1] : [0, -1];
        $captures = [
            offset($field, [-1, $direction[1]]),
            offset($field, [1, $direction[1]])
        ];
        foreach ($captures as $capture) {
            if (isValidField($capture)) {
                $attacks[] = $capture;
            }
        }
        return $attacks;
    }

    public function getPawnMoves($field) {
        $pieceColor = getPieceColor($this->getPiece($field));
        $moves = [];
        $direction = $pieceColor == \chess\pgn\WHITE ? [0, 1] : [0, -1];
        $startRank = $pieceColor == \chess\pgn\WHITE ? "2" : "7";
        $target = offset($field, $direction);
        if (isValidField($target) && $this->getPiece($target) == \chess\pgn\EMPTY_PIECE) {
            $moves[] = $field . $target;
        }
        // check double move
        if ($field[1] == $startRank) {
            $target = offset($field, [$direction[0], $direction[1] * 2]);
            if (isValidField($target) && $this->getPiece($target) == \chess\pgn\EMPTY_PIECE) {
                $moves[] = $field . $target;
            }
        }

        // check captures
        $attacks = $this->getPawnAttacks($field);
        foreach ($attacks as $attack) {
            if(getPieceColor($this->getPiece($attack)) == opponent($pieceColor)) {
                $moves[] = $field . $attack;
            }
        }

        // check en passant
        $enPassant = $this->enPassant;
        if (array_search($enPassant, $attacks) !== false) {
            $moves[] = $field . $enPassant;
        }
        return $moves;
    }

    public function isCheck() {
        $pieces = $this->findPieces($this->turn == WHITE ? WhitePiece::KING : BlackPiece::KING);
        if(empty($pieces)) {
            return false;
        }

        return $this->isAttacked($pieces[0], opponent($this->turn));
    }

    public function getMovesByColor($color) {
        $moves = [];
        for ($i = 0; $i < 64; $i++) {
            if ($this->board[$i] == \chess\pgn\EMPTY_PIECE ||
                getPieceColor($this->board[$i]) != $color) {
                continue;
            }
            $pieceMoves = $this->getPieceMoves($i);
            $moves = array_merge($moves, $pieceMoves);
        }
        return $moves;
    }

    public function getPieces() {
        $pieces = [];
        for ($i = 0; $i < 64; $i++) {
            if ($this->board[$i] != \chess\pgn\EMPTY_PIECE) {
                $pieces[] = toField($i);
            }
        }
        return $pieces;
    }

    public function getWhitePieces() {
        $pieces = [];
        for ($i = 0; $i < 64; $i++) {
            if (getPieceColor($this->board[$i]) == \chess\pgn\WHITE) {
                $pieces[] = toField($i);
            }
        }
        return $pieces;
    }

    public function getBlackPieces() {
        $pieces = [];
        for ($i = 0; $i < 64; $i++) {
            if (getPieceColor($this->board[$i]) == \chess\pgn\BLACK) {
                $pieces[] = toField($i);
            }
        }
        return $pieces;
    }

    public function getAttacksFrom($field) {
        $attacks = [];
        $piece = $this->getPiece($field);
        $pieceType = getPieceType($piece);
        switch ($pieceType) {
            case \chess\pgn\PAWN:
                $attacks = $this->getPawnAttacks($field);
                break;
            case \chess\pgn\KNIGHT:
                $attacks = $this->getKnightAttacks($field);
                break;
            case \chess\pgn\BISHOP:
                $attacks = $this->getBishopAttacks($field);
                break;
            case \chess\pgn\ROOK:
                $attacks = $this->getRookAttacks($field);
                break;
            case \chess\pgn\QUEEN:
                $attacks = $this->getQueenAttacks($field);
                break;
            case \chess\pgn\KING:
                $attacks = $this->getKingAttacks($field);
                break;
        }
        return $attacks;
    }

    public function getMoves(){
        return $this->getMovesByColor($this->turn);
    }

    public function getAllAttacks($color){
        $attacks = [];
        $pieces = $color == WHITE ? $this->getWhitePieces() : $this->getBlackPieces();
        foreach($pieces as $piece) {
            $attacks = array_merge($attacks, $this->getAttacksFrom($piece));
        }
        return array_unique($attacks);
    }

    public function isAttacked($field, $color) {
        $attacks = $this->getAllAttacks($color);

        foreach($attacks as $attack) {
            if($attack == $field) {
                return true;
            }
        }
        return false;
    }

    public function findPieces($piece) {
        $pieces = [];
        for ($i = 0; $i < 64; $i++) {
            if ($this->board[$i] == $piece) {
                $pieces[] = toField($i);
            }
        }
        return $pieces;
    }

    public function countWhitePieces() {
        $count = 0;
        foreach ($this->board as $piece) {
            if (getPieceColor($piece) == \chess\pgn\WHITE) {
                $count++;
            }
        }
        return $count;
    }

    public function countBlackPieces() {
        $count = 0;
        foreach ($this->board as $piece) {
            if (getPieceColor($piece) == \chess\pgn\BLACK) {
                $count++;
            }
        }
        return $count;
    }

    public function countPieces(){
        return $this->countWhitePieces() + $this->countBlackPieces();
    }
}