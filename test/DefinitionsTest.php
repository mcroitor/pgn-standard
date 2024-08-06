<?php

namespace chess\pgn;

// Include the definitions file
require_once __DIR__ . "/../pgn/definitions.php";

use PHPUnit\Framework\TestCase;

final class DefinitionsTest extends TestCase {
    public function testColors() {
        $this->assertEquals(" ", NO_COLOR);
        $this->assertEquals("w", WHITE);
        $this->assertEquals("b", BLACK);
    }

    public function testPieces() {
        $this->assertEquals(" ", EMPTY_PIECE);
        $this->assertEquals("P", PAWN);
        $this->assertEquals("N", KNIGHT);
        $this->assertEquals("B", BISHOP);
        $this->assertEquals("R", ROOK);
        $this->assertEquals("Q", QUEEN);
        $this->assertEquals("K", KING);
    }

    public function testWhitePieces() {
        $this->assertEquals("P", WhitePiece::PAWN);
        $this->assertEquals("N", WhitePiece::KNIGHT);
        $this->assertEquals("B", WhitePiece::BISHOP);
        $this->assertEquals("R", WhitePiece::ROOK);
        $this->assertEquals("Q", WhitePiece::QUEEN);
        $this->assertEquals("K", WhitePiece::KING);

        $this->assertEquals("p", BlackPiece::PAWN);
        $this->assertEquals("n", BlackPiece::KNIGHT);
        $this->assertEquals("b", BlackPiece::BISHOP);
        $this->assertEquals("r", BlackPiece::ROOK);
        $this->assertEquals("q", BlackPiece::QUEEN);
        $this->assertEquals("k", BlackPiece::KING);
    }

    public function testGetPieceColor() {
        $this->assertEquals(WHITE, getPieceColor(WhitePiece::PAWN));
        $this->assertEquals(WHITE, getPieceColor(WhitePiece::KNIGHT));
        $this->assertEquals(WHITE, getPieceColor(WhitePiece::BISHOP));
        $this->assertEquals(WHITE, getPieceColor(WhitePiece::ROOK));
        $this->assertEquals(WHITE, getPieceColor(WhitePiece::QUEEN));
        $this->assertEquals(WHITE, getPieceColor(WhitePiece::KING));

        $this->assertEquals(BLACK, getPieceColor(BlackPiece::PAWN));
        $this->assertEquals(BLACK, getPieceColor(BlackPiece::KNIGHT));
        $this->assertEquals(BLACK, getPieceColor(BlackPiece::BISHOP));
        $this->assertEquals(BLACK, getPieceColor(BlackPiece::ROOK));
        $this->assertEquals(BLACK, getPieceColor(BlackPiece::QUEEN));
        $this->assertEquals(BLACK, getPieceColor(BlackPiece::KING));

        $this->assertEquals(NO_COLOR, getPieceColor(EMPTY_PIECE));
    }

    public function testGetPieceType() {
        $this->assertEquals(PAWN, getPieceType(WhitePiece::PAWN));
        $this->assertEquals(KNIGHT, getPieceType(WhitePiece::KNIGHT));
        $this->assertEquals(BISHOP, getPieceType(WhitePiece::BISHOP));
        $this->assertEquals(ROOK, getPieceType(WhitePiece::ROOK));
        $this->assertEquals(QUEEN, getPieceType(WhitePiece::QUEEN));
        $this->assertEquals(KING, getPieceType(WhitePiece::KING));

        $this->assertEquals(PAWN, getPieceType(BlackPiece::PAWN));
        $this->assertEquals(KNIGHT, getPieceType(BlackPiece::KNIGHT));
        $this->assertEquals(BISHOP, getPieceType(BlackPiece::BISHOP));
        $this->assertEquals(ROOK, getPieceType(BlackPiece::ROOK));
        $this->assertEquals(QUEEN, getPieceType(BlackPiece::QUEEN));
        $this->assertEquals(KING, getPieceType(BlackPiece::KING));

        $this->assertEquals(EMPTY_PIECE, getPieceType(EMPTY_PIECE));
    }

    public function testRow() {
        $this->assertEquals(0, row("a8"));
        $this->assertEquals(1, row("a7"));
        $this->assertEquals(2, row("a6"));
        $this->assertEquals(3, row("a5"));
        $this->assertEquals(4, row("a4"));
        $this->assertEquals(5, row("a3"));
        $this->assertEquals(6, row("a2"));
        $this->assertEquals(7, row("a1"));
    }

    public function testColumn() {
        $this->assertEquals(0, column("a8"));
        $this->assertEquals(1, column("b8"));
        $this->assertEquals(2, column("c8"));
        $this->assertEquals(3, column("d8"));
        $this->assertEquals(4, column("e8"));
        $this->assertEquals(5, column("f8"));
        $this->assertEquals(6, column("g8"));
        $this->assertEquals(7, column("h8"));
    }

    public function testToIndex() {
        $this->assertEquals(0, toIndex("a8"));
        $this->assertEquals(1, toIndex("b8"));
        $this->assertEquals(2, toIndex("c8"));
        $this->assertEquals(3, toIndex("d8"));
        $this->assertEquals(4, toIndex("e8"));
        $this->assertEquals(5, toIndex("f8"));
        $this->assertEquals(6, toIndex("g8"));
        $this->assertEquals(7, toIndex("h8"));

        $this->assertEquals(56, toIndex("a1"));
        $this->assertEquals(57, toIndex("b1"));
        $this->assertEquals(58, toIndex("c1"));
        $this->assertEquals(59, toIndex("d1"));
        $this->assertEquals(60, toIndex("e1"));
        $this->assertEquals(61, toIndex("f1"));
        $this->assertEquals(62, toIndex("g1"));
        $this->assertEquals(63, toIndex("h1"));
    }

    public function testToField() {
        $this->assertEquals("a8", toField(0));
        $this->assertEquals("b8", toField(1));
        $this->assertEquals("c8", toField(2));
        $this->assertEquals("d8", toField(3));
        $this->assertEquals("e8", toField(4));
        $this->assertEquals("f8", toField(5));
        $this->assertEquals("g8", toField(6));
        $this->assertEquals("h8", toField(7));

        $this->assertEquals("a1", toField(56));
        $this->assertEquals("b1", toField(57));
        $this->assertEquals("c1", toField(58));
        $this->assertEquals("d1", toField(59));
        $this->assertEquals("e1", toField(60));
        $this->assertEquals("f1", toField(61));
        $this->assertEquals("g1", toField(62));
        $this->assertEquals("h1", toField(63));
    }

    function testIsValidField() {
        $this->assertTrue(isValidField("a1"));
        $this->assertTrue(isValidField("h1"));
        $this->assertTrue(isValidField("a8"));
        $this->assertTrue(isValidField("h8"));

        $this->assertFalse(isValidField("i1"));
        $this->assertFalse(isValidField("a9"));
        $this->assertFalse(isValidField("i9"));
        $this->assertFalse(isValidField("i0"));
    }
}