<?php
namespace chess\pgn;

require_once __DIR__ . "/../pgn/definitions.php";
require_once __DIR__ . "/../pgn/board.php";

use PHPUnit\Framework\TestCase;

final class BoardTest extends TestCase {
    private function write($type, $message) {
        echo "[{$type}] {$message}" . PHP_EOL;
        ob_flush();
    }
    private function info($message) {
        $this->write('INFO', $message);
    }
    private function error($message) {
        $this->write('ERROR', $message);
    }
    private function debug($message) {
        $this->write('DEBUG', $message);
    }

    public function testEmptyBoard() {
        $this->info("Testing empty board");
        $board = new Board();

        // check piece colors on empty board
        for ($row = 1; $row <= 8; $row++) {
            for($col = 'a'; $col <= 'h'; $col++) {
                $this->assertEquals(NO_COLOR, getPieceColor($board->getPiece($col . $row)));
            }
        }

        // check piece types on empty board
        for ($row = 1; $row <= 8; $row++) {
            for($col = 'a'; $col <= 'h'; $col++) {
                $this->assertEquals(EMPTY_PIECE, getPieceType($board->getPiece($col . $row)));
            }
        }

        // count pieces on empty board
        $this->assertEquals(0, $board->countPieces());
        $this->assertEquals(0, $board->countWhitePieces());
        $this->assertEquals(0, $board->countBlackPieces());

        // get fen on empty board
        $this->assertEquals("8/8/8/8/8/8/8/8 w KQkq - 0 1", $board->toFen());
    }

    public function testInitBoard() {
        $this->info("Testing initial board");
        $board = new Board(Board::INITIAL_FEN);

        // check piece colors on initial board
        for($col = 'a'; $col <= 'h'; $col++) {
            $this->assertEquals(WHITE, getPieceColor($board->getPiece($col . '1')));
            $this->assertEquals(WHITE, getPieceColor($board->getPiece($col . '2')));
            $this->assertEquals(NO_COLOR, getPieceColor($board->getPiece($col . '3')));
            $this->assertEquals(NO_COLOR, getPieceColor($board->getPiece($col . '4')));
            $this->assertEquals(NO_COLOR, getPieceColor($board->getPiece($col . '5')));
            $this->assertEquals(NO_COLOR, getPieceColor($board->getPiece($col . '6')));
            $this->assertEquals(BLACK, getPieceColor($board->getPiece($col . '7')));
            $this->assertEquals(BLACK, getPieceColor($board->getPiece($col . '8')));
        }

        // check piece types on initial board
        $this->assertEquals(ROOK, getPieceType($board->getPiece('a1')));
        $this->assertEquals(KNIGHT, getPieceType($board->getPiece('b1')));
        $this->assertEquals(BISHOP, getPieceType($board->getPiece('c1')));
        $this->assertEquals(QUEEN, getPieceType($board->getPiece('d1')));
        $this->assertEquals(KING, getPieceType($board->getPiece('e1')));
        $this->assertEquals(BISHOP, getPieceType($board->getPiece('f1')));
        $this->assertEquals(KNIGHT, getPieceType($board->getPiece('g1')));
        $this->assertEquals(ROOK, getPieceType($board->getPiece('h1')));

        for($col = 'a'; $col <= 'h'; $col++) {
            $this->assertEquals(PAWN, getPieceType($board->getPiece($col . '2')));
            $this->assertEquals(EMPTY_PIECE, getPieceType($board->getPiece($col . '3')));
            $this->assertEquals(EMPTY_PIECE, getPieceType($board->getPiece($col . '4')));
            $this->assertEquals(EMPTY_PIECE, getPieceType($board->getPiece($col . '5')));
            $this->assertEquals(EMPTY_PIECE, getPieceType($board->getPiece($col . '6')));
            $this->assertEquals(PAWN, getPieceType($board->getPiece($col . '7')));
        }

        $this->assertEquals(ROOK, getPieceType($board->getPiece('a8')));
        $this->assertEquals(KNIGHT, getPieceType($board->getPiece('b8')));
        $this->assertEquals(BISHOP, getPieceType($board->getPiece('c8')));
        $this->assertEquals(QUEEN, getPieceType($board->getPiece('d8')));
        $this->assertEquals(KING, getPieceType($board->getPiece('e8')));
        $this->assertEquals(BISHOP, getPieceType($board->getPiece('f8')));
        $this->assertEquals(KNIGHT, getPieceType($board->getPiece('g8')));
        $this->assertEquals(ROOK, getPieceType($board->getPiece('h8')));

        // count pieces on initial board
        $this->assertEquals(32, $board->countPieces());
        $this->assertEquals(16, $board->countWhitePieces());
        $this->assertEquals(16, $board->countBlackPieces());
    }

    public function testRetiPosition() {
        $this->info("Testing Reti position");
        $board = new Board("7K/8/k1P5/7p/8/8/8/8 w - - 0 1");

        // count pieces on Reti position
        $this->assertEquals(4, $board->countPieces());
        $this->assertEquals(2, $board->countWhitePieces());
        $this->assertEquals(2, $board->countBlackPieces());

        // check piece colors on Reti position
        $this->assertEquals(WHITE, getPieceColor($board->getPiece('h8')));
        $this->assertEquals(WHITE, getPieceColor($board->getPiece('c6')));
        $this->assertEquals(BLACK, getPieceColor($board->getPiece('a6')));
        $this->assertEquals(BLACK, getPieceColor($board->getPiece('h5')));

        // check piece types on Reti position
        $this->assertEquals(KING, getPieceType($board->getPiece('h8')));
        $this->assertEquals(PAWN, getPieceType($board->getPiece('c6')));
        $this->assertEquals(KING, getPieceType($board->getPiece('a6')));
        $this->assertEquals(PAWN, getPieceType($board->getPiece('h5')));

        // get fen on Reti position
        $this->assertEquals("7K/8/k1P5/7p/8/8/8/8 w - - 0 1", $board->toFen());

        // check castling rights on Reti position
        $this->assertEquals(NO_CASTLING, $board->getCastling());

        // check en passant target on Reti position
        $this->assertEquals(NO_EN_PASSANT, $board->getEnPassant());

        // generate all possible moves on Reti position
        $moves = $board->getMoves();
        $this->assertEquals(4, count($moves));

        $pawnMoves = $board->getPieceMoves(toIndex('c6'));
        $this->assertEquals(1, count($pawnMoves));
        $this->assertEquals('c6c7', $pawnMoves[0]);
    }

    public function testKingAttacks(){
        $this->info("Testing king attacks");
        $board = new Board();

        $board->setPiece('e4', WhitePiece::KING);
        $board->setPiece('e8', BlackPiece::KING);
        $board->setPiece('e5', BlackPiece::PAWN);
        $board->setPiece('f5', WhitePiece::PAWN);

        $attacks = $board->getKingAttacks('e4');
        $this->assertEquals(8, count($attacks));

        $attacks = $board->getKingAttacks('e8');
        $this->assertEquals(5, count($attacks));
    }

    public function testKnightAttacks(){
        $this->info("Testing knight attacks");
        $board = new Board();

        $board->setPiece('e4', WhitePiece::KNIGHT);
        $board->setPiece('e8', BlackPiece::KNIGHT);
        $board->setPiece('d6', BlackPiece::PAWN);
        $board->setPiece('f6', WhitePiece::PAWN);

        $attacks = $board->getKnightAttacks('e4');
        $this->assertEquals(8, count($attacks));
        
        $attacks = $board->getKnightAttacks('e8');
        $this->assertEquals(4, count($attacks));
    }

    public function testBishopAttacks(){
        $this->info("Testing bishop attacks");
        $board = new Board();

        $board->setPiece('e4', WhitePiece::BISHOP);
        $board->setPiece('e8', BlackPiece::BISHOP);
        $board->setPiece('d5', BlackPiece::PAWN);
        $board->setPiece('f5', WhitePiece::PAWN);

        $attacks = $board->getBishopAttacks('e4');
        $this->assertEquals(8, count($attacks));
        
        $attacks = $board->getBishopAttacks('e8');
        $this->assertEquals(7, count($attacks));
    }

    public function testRookAttacks(){
        $this->info("Testing rook attacks");
        $board = new Board();

        $board->setPiece('e4', WhitePiece::ROOK);
        $board->setPiece('e8', BlackPiece::ROOK);
        $board->setPiece('e5', BlackPiece::PAWN);
        $board->setPiece('b4', WhitePiece::PAWN);

        $attacks = $board->getRookAttacks('e4');
        $this->assertEquals(10, count($attacks));
        
        $attacks = $board->getRookAttacks('e8');
        $this->assertEquals(10, count($attacks));
    }

    public function testQueenAttacks(){
        $this->info("Testing queen attacks");
        $board = new Board();

        $board->setPiece('d1', WhitePiece::QUEEN);
        $board->setPiece('d8', BlackPiece::QUEEN);
        $board->setPiece('g4', BlackPiece::PAWN);
        $board->setPiece('c2', WhitePiece::PAWN);

        $attacks = $board->getQueenAttacks('d1');
        $this->assertEquals(18, count($attacks));
        
        $attacks = $board->getQueenAttacks('d8');
        $this->assertEquals(21, count($attacks));
    }

    public function testMoveOnBoard() {
        $this->info("Testing move on board");
        $board = new Board(Board::INITIAL_FEN);

        // move white pawn
        $board->move('e2','e4');
        $this->assertEquals(WHITE, getPieceColor($board->getPiece('e4')));
        $this->assertEquals(PAWN, getPieceType($board->getPiece('e4')));
        $this->assertEquals("rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq - 0 1", $board->toFen());
        
        // move black pawn
        $board->move('e7','e5');
        $this->assertEquals(BLACK, getPieceColor($board->getPiece('e5')));
        $this->assertEquals(PAWN, getPieceType($board->getPiece('e5')));
        $this->assertEquals("rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq - 0 2", $board->toFen());

        // move white pawn
        $board->move('d2','d4');
        $this->assertEquals(WHITE, getPieceColor($board->getPiece('d4')));
        $this->assertEquals(PAWN, getPieceType($board->getPiece('d4')));
        $this->assertEquals("rnbqkbnr/pppp1ppp/8/4p3/3PP3/8/PPP2PPP/RNBQKBNR b KQkq - 0 2", $board->toFen());

        // move black pawn
        $board->move('e5','d4');
        $this->assertEquals(BLACK, getPieceColor($board->getPiece('d4')));
        $this->assertEquals(PAWN, getPieceType($board->getPiece('d4')));
        $this->assertEquals("rnbqkbnr/pppp1ppp/8/8/3pP3/8/PPP2PPP/RNBQKBNR w KQkq - 0 3", $board->toFen());
    }

    public function testKingMoves() {
        $this->info("Testing king moves");
        $board = new Board();

        $field = 'e4';
        $board->setPiece($field, WhitePiece::KING);

        // generate all possible moves for white king
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(8, count($moves));
        $this->assertContains('e4e5', $moves);
        $this->assertContains('e4d5', $moves);
        $this->assertContains('e4d4', $moves);
        $this->assertContains('e4d3', $moves);
        $this->assertContains('e4e3', $moves);
        $this->assertContains('e4f3', $moves);
        $this->assertContains('e4f4', $moves);
        $this->assertContains('e4f5', $moves);

        // add a white pawn on e5
        $board->setPiece('e5', WhitePiece::PAWN);
        // add a black rook on f3
        $board->setPiece('f3', BlackPiece::ROOK);

        // generate all possible moves for white king
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(3, count($moves));
        $this->assertContains('e4d5', $moves);
        $this->assertContains('e4d4', $moves);
        $this->assertContains('e4f3', $moves);
    }

    public function testBishopMoves() {
        $this->info("Testing bishop moves");
        $board = new Board();

        $field = 'e4';
        $board->setPiece($field, WhitePiece::BISHOP);

        // add a white pawn on e5
        $board->setPiece('e5', WhitePiece::PAWN);
        // add a black rook on f3
        $board->setPiece('f3', BlackPiece::ROOK);
        // add a white pawn on g6
        $board->setPiece('g6', WhitePiece::PAWN);

        // generate all possible moves for white bishop
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(9, count($moves));
        $this->assertContains('e4d3', $moves);
        $this->assertContains('e4c2', $moves);
        $this->assertContains('e4b1', $moves);
        $this->assertContains('e4d5', $moves);
        $this->assertContains('e4c6', $moves);
        $this->assertContains('e4b7', $moves);
        $this->assertContains('e4a8', $moves);
        $this->assertContains('e4f3', $moves);
        $this->assertContains('e4f5', $moves);
    }

    public function testRookMoves(){
        $this->info("Testing rook moves");
        $board = new Board();

        $field = 'e4';
        $board->setPiece($field, WhitePiece::ROOK);

        // add a white pawn on e5
        $board->setPiece('e5', WhitePiece::PAWN);
        // add a black rook on f3
        $board->setPiece('f3', BlackPiece::ROOK);
        // add a black rook on b4
        $board->setPiece('b4', BlackPiece::ROOK);
        // add a white pawn on d5
        $board->setPiece('d5', WhitePiece::PAWN);

        // generate all possible moves for white rook
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(9, count($moves));
        $this->assertContains('e4e3', $moves);
        $this->assertContains('e4e2', $moves);
        $this->assertContains('e4e1', $moves);
        $this->assertContains('e4d4', $moves);
        $this->assertContains('e4c4', $moves);
        $this->assertContains('e4b4', $moves);
        $this->assertContains('e4f4', $moves);
        $this->assertContains('e4g4', $moves);
        $this->assertContains('e4h4', $moves);
    }

    public function testQueenMoves() {
        $this->info("Testing queen moves");
        $board = new Board();

        $field = 'e4';
        $board->setPiece($field, WhitePiece::QUEEN);

        // add a white pawn on e5
        $board->setPiece('e5', WhitePiece::PAWN);
        // add a black rook on f3
        $board->setPiece('f3', BlackPiece::ROOK);

        // generate all possible moves for white queen
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(21, count($moves));
        $this->assertContains('e4e3', $moves);
        $this->assertContains('e4e2', $moves);
        $this->assertContains('e4e1', $moves);
        $this->assertContains('e4d4', $moves);
        $this->assertContains('e4c4', $moves);
        $this->assertContains('e4b4', $moves);
        $this->assertContains('e4a4', $moves);
        $this->assertContains('e4f4', $moves);
        $this->assertContains('e4g4', $moves);
        $this->assertContains('e4h4', $moves);
        $this->assertContains('e4d3', $moves);
        $this->assertContains('e4c2', $moves);
        $this->assertContains('e4b1', $moves);
        $this->assertContains('e4f3', $moves);
        $this->assertContains('e4f5', $moves);
        $this->assertContains('e4g6', $moves);
        $this->assertContains('e4h7', $moves);
        $this->assertContains('e4d5', $moves);
        $this->assertContains('e4c6', $moves);
        $this->assertContains('e4b7', $moves);
        $this->assertContains('e4a8', $moves);
    }

    public function testPawnMoves() {
        $this->info("Testing pawn moves");
        $board = new Board();

        $field = 'e2';
        $board->setPiece($field, WhitePiece::PAWN);

        // generate all possible moves for white pawn
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(2, count($moves));
        $this->assertContains('e2e3', $moves);
        $this->assertContains('e2e4', $moves);

        // add a black pawn on d3
        $board->setPiece('d3', BlackPiece::PAWN);
        // add a black pawn on e4
        $board->setPiece('e4', BlackPiece::PAWN);

        // generate all possible moves for white pawn
        $moves = $board->getPieceMoves(toIndex($field));
        $this->assertEquals(2, count($moves));
        $this->assertContains('e2e3', $moves);
        $this->assertContains('e2d3', $moves);

    }

    public function testGetMoves() {
        $this->info("Testing getMoves");
        $board = new Board(Board::INITIAL_FEN);

        // generate all possible moves on initial board
        $moves = $board->getMoves();
        $this->assertEquals(20, count($moves));

        // generate all possible moves on Reti position
        $board = new Board("7K/8/k1P5/7p/8/8/8/8 w - - 0 1");
        $moves = $board->getMoves();
        $this->assertEquals(4, count($moves));
        $board->move('h8', 'g7');
        $moves = $board->getMoves();
        $this->assertEquals(5, count($moves));
    }
}
