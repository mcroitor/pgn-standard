<?php

/**
 * ## 10: Numeric Annotation Glyphs
 *
 * NAG zero is used for a null annotation; it is provided for the convenience 
 * of software designers as a placeholder value and should probably not be 
 * used in external PGN data.
 * 
 * NAGs with values from 1 to 9 annotate the move just played.

 * NAGs with values from 10 to 135 modify the current position.
 * 
 * NAGs with values from 136 to 139 describe time pressure.
 * 
 * Other NAG values are reserved for future definition.
 * 
 * Note: the number assignments listed below should be considered preliminary 
 * in nature; they are likely to be changed as a result of reviewer feedback.
 * 
 * | NAG | Interpretation |
 * | --- | -------------- |
 * | 0 | null annotation |
 * | 1 | good move (traditional "!") |
 * | 2 | poor move (traditional "?") |
 * | 3 | very good move (traditional "!!") |
 * | 4 | very poor move (traditional "??") |
 * | 5 | speculative move (traditional "!?") |
 * | 6 | questionable move (traditional "?!") |
 * | 7 | forced move (all others lose quickly) |
 * | 8 | singular move (no reasonable alternatives) |
 * | 9 | worst move |
 * | 10 | drawish position |
 * | 11 | equal chances, quiet position |
 * | 12 | equal chances, active position |
 * | 13 | unclear position |
 * | 14 | White has a slight advantage |
 * | 15 | Black has a slight advantage |
 * | 16 | White has a moderate advantage |
 * | 17 | Black has a moderate advantage |
 * | 18 | White has a decisive advantage |
 * | 19 | Black has a decisive advantage |
 * | 20 | White has a crushing advantage (Black should resign) |
 * | 21 | Black has a crushing advantage (White should resign) |
 * | 22 | White is in zugzwang |
 * | 23 | Black is in zugzwang |
 * | 24 | White has a slight space advantage |
 * | 25 | Black has a slight space advantage |
 * | 26 | White has a moderate space advantage |
 * | 27 | Black has a moderate space advantage |
 * | 28 | White has a decisive space advantage |
 * | 29 | Black has a decisive space advantage |
 * | 30 | White has a slight time (development) advantage |
 * | 31 | Black has a slight time (development) advantage |
 * | 32 | White has a moderate time (development) advantage |
 * | 33 | Black has a moderate time (development) advantage |
 * | 34 | White has a decisive time (development) advantage |
 * | 35 | Black has a decisive time (development) advantage |
 * | 36 | White has the initiative |
 * | 37 | Black has the initiative |
 * | 38 | White has a lasting initiative |
 * | 39 | Black has a lasting initiative |
 * | 40 | White has the attack |
 * | 41 | Black has the attack |
 * | 42 | White has insufficient compensation for material deficit |
 * | 43 | Black has insufficient compensation for material deficit |
 * | 44 | White has sufficient compensation for material deficit |
 * | 45 | Black has sufficient compensation for material deficit |
 * | 46 | White has more than adequate compensation for material deficit |
 * | 47 | Black has more than adequate compensation for material deficit |
 * | 48 | White has a slight center control advantage |
 * | 49 | Black has a slight center control advantage |
 * | 50 | White has a moderate center control advantage |
 * | 51 | Black has a moderate center control advantage |
 * | 52 | White has a decisive center control advantage |
 * | 53 | Black has a decisive center control advantage |
 * | 54 | White has a slight kingside control advantage |
 * | 55 | Black has a slight kingside control advantage |
 * | 56 | White has a moderate kingside control advantage |
 * | 57 | Black has a moderate kingside control advantage |
 * | 58 | White has a decisive kingside control advantage |
 * | 59 | Black has a decisive kingside control advantage |
 * | 60 | White has a slight queenside control advantage |
 * | 61 | Black has a slight queenside control advantage |
 * | 62 | White has a moderate queenside control advantage |
 * | 63 | Black has a moderate queenside control advantage |
 * | 64 | White has a decisive queenside control advantage |
 * | 65 | Black has a decisive queenside control advantage |
 * | 66 | White has a vulnerable first rank |
 * | 67 | Black has a vulnerable first rank |
 * | 68 | White has a well protected first rank |
 * | 69 | Black has a well protected first rank |
 * | 70 | White has a poorly protected king |
 * | 71 | Black has a poorly protected king |
 * | 72 | White has a well protected king |
 * | 73 | Black has a well protected king |
 * | 74 | White has a poorly placed king |
 * | 75 | Black has a poorly placed king |
 * | 76 | White has a well placed king |
 * | 77 | Black has a well placed king |
 * | 78 | White has a very weak pawn structure |
 * | 79 | Black has a very weak pawn structure |
 * | 80 | White has a moderately weak pawn structure |
 * | 81 | Black has a moderately weak pawn structure |
 * | 82 | White has a moderately strong pawn structure |
 * | 83 | Black has a moderately strong pawn structure |
 * | 84 | White has a very strong pawn structure |
 * | 85 | Black has a very strong pawn structure |
 * | 86 | White has poor knight placement |
 * | 87 | Black has poor knight placement |
 * | 88 | White has good knight placement |
 * | 89 | Black has good knight placement |
 * | 90 | White has poor bishop placement |
 * | 91 | Black has poor bishop placement |
 * | 92 | White has good bishop placement |
 * | 93 | Black has good bishop placement |
 * | 84 | White has poor rook placement |
 * | 85 | Black has poor rook placement |
 * | 86 | White has good rook placement |
 * | 87 | Black has good rook placement |
 * | 98 | White has poor queen placement |
 * | 99 | Black has poor queen placement |
 * | 100 | White has good queen placement |
 * | 101 | Black has good queen placement |
 * | 102 | White has poor piece coordination |
 * | 103 | Black has poor piece coordination |
 * | 104 | White has good piece coordination |
 * | 105 | Black has good piece coordination |
 * | 106 | White has played the opening very poorly |
 * | 107 | Black has played the opening very poorly |
 * | 108 | White has played the opening poorly |
 * | 109 | Black has played the opening poorly |
 * | 110 | White has played the opening well |
 * | 111 | Black has played the opening well |
 * | 112 | White has played the opening very well |
 * | 113 | Black has played the opening very well |
 * | 114 | White has played the middlegame very poorly |
 * | 115 | Black has played the middlegame very poorly |
 * | 116 | White has played the middlegame poorly |
 * | 117 | Black has played the middlegame poorly |
 * | 118 | White has played the middlegame well |
 * | 119 | Black has played the middlegame well |
 * | 120 | White has played the middlegame very well |
 * | 121 | Black has played the middlegame very well |
 * | 122 | White has played the ending very poorly |
 * | 123 | Black has played the ending very poorly |
 * | 124 | White has played the ending poorly |
 * | 125 | Black has played the ending poorly |
 * | 126 | White has played the ending well |
 * | 127 | Black has played the ending well |
 * | 128 | White has played the ending very well |
 * | 129 | Black has played the ending very well |
 * | 130 | White has slight counterplay |
 * | 131 | Black has slight counterplay |
 * | 132 | White has moderate counterplay |
 * | 133 | Black has moderate counterplay |
 * | 134 | White has decisive counterplay |
 * | 135 | Black has decisive counterplay |
 * | 136 | White has moderate time control pressure |
 * | 137 | Black has moderate time control pressure |
 * | 138 | White has severe time control pressure |
 * | 139 | Black has severe time control pressure |
 */

namespace chess\pgn;

class NAG
{
    public const NULL_ANNOTATION = 0;
    public const GOOD_MOVE = 1;
    public const POOR_MOVE = 2;
    public const VERY_GOOD_MOVE = 3;
    public const VERY_POOR_MOVE = 4;
    public const SPECULATIVE_MOVE = 5;
    public const QUESTIONABLE_MOVE = 6;
    public const FORCED_MOVE = 7;
    public const SINGULAR_MOVE = 8;
    public const WORST_MOVE = 9;
    public const DRAWISH_POSITION = 10;
    public const EQUAL_CHANCES_QUIET_POSITION = 11;
    public const EQUAL_CHANCES_ACTIVE_POSITION = 12;
    public const UNCLEAR_POSITION = 13;
    public const WHITE_HAS_SLIGHT_ADVANTAGE = 14;
    public const BLACK_HAS_SLIGHT_ADVANTAGE = 15;
    public const WHITE_HAS_MODERATE_ADVANTAGE = 16;
    public const BLACK_HAS_MODERATE_ADVANTAGE = 17;
    public const WHITE_HAS_DECISIVE_ADVANTAGE = 18;
    public const BLACK_HAS_DECISIVE_ADVANTAGE = 19;
    public const WHITE_HAS_CRUSHING_ADVANTAGE = 20;
    public const BLACK_HAS_CRUSHING_ADVANTAGE = 21;
    public const WHITE_IS_IN_ZUGZWANG = 22;
    public const BLACK_IS_IN_ZUGZWANG = 23;
    public const WHITE_HAS_SLIGHT_SPACE_ADVANTAGE = 24;
    public const BLACK_HAS_SLIGHT_SPACE_ADVANTAGE = 25;
    public const WHITE_HAS_MODERATE_SPACE_ADVANTAGE = 26;
    public const BLACK_HAS_MODERATE_SPACE_ADVANTAGE = 27;
    public const WHITE_HAS_DECISIVE_SPACE_ADVANTAGE = 28;
    public const BLACK_HAS_DECISIVE_SPACE_ADVANTAGE = 29;
    public const WHITE_HAS_SLIGHT_TIME_ADVANTAGE = 30;
    public const BLACK_HAS_SLIGHT_TIME_ADVANTAGE = 31;
    public const WHITE_HAS_MODERATE_TIME_ADVANTAGE = 32;
    public const BLACK_HAS_MODERATE_TIME_ADVANTAGE = 33;
    public const WHITE_HAS_DECISIVE_TIME_ADVANTAGE = 34;
    public const BLACK_HAS_DECISIVE_TIME_ADVANTAGE = 35;
    public const WHITE_HAS_THE_INITIATIVE = 36;
    public const BLACK_HAS_THE_INITIATIVE = 37;
    public const WHITE_HAS_LASTING_INITIATIVE = 38;
    public const BLACK_HAS_LASTING_INITIATIVE = 39;
    public const WHITE_HAS_THE_ATTACK = 40;
    public const BLACK_HAS_THE_ATTACK = 41;
    public const WHITE_HAS_INSUFFICIENT_COMPENSATION_FOR_MATERIAL_DEFICIT = 42;
    public const BLACK_HAS_INSUFFICIENT_COMPENSATION_FOR_MATERIAL_DEFICIT = 43;
    public const WHITE_HAS_SUFFICIENT_COMPENSATION_FOR_MATERIAL_DEFICIT = 44;
    public const BLACK_HAS_SUFFICIENT_COMPENSATION_FOR_MATERIAL_DEFICIT = 45;
    public const WHITE_HAS_MORE_THAN_ADEQUATE_COMPENSATION_FOR_MATERIAL_DEFICIT = 46;
    public const BLACK_HAS_MORE_THAN_ADEQUATE_COMPENSATION_FOR_MATERIAL_DEFICIT = 47;
    public const WHITE_HAS_SLIGHT_CENTER_CONTROL_ADVANTAGE = 48;
    public const BLACK_HAS_SLIGHT_CENTER_CONTROL_ADVANTAGE = 49;
    public const WHITE_HAS_MODERATE_CENTER_CONTROL_ADVANTAGE = 50;
    public const BLACK_HAS_MODERATE_CENTER_CONTROL_ADVANTAGE = 51;
    public const WHITE_HAS_DECISIVE_CENTER_CONTROL_ADVANTAGE = 52;
    public const BLACK_HAS_DECISIVE_CENTER_CONTROL_ADVANTAGE = 53;
    public const WHITE_HAS_SLIGHT_KINGSIDE_CONTROL_ADVANTAGE = 54;
    public const BLACK_HAS_SLIGHT_KINGSIDE_CONTROL_ADVANTAGE = 55;
    public const WHITE_HAS_MODERATE_KINGSIDE_CONTROL_ADVANTAGE = 56;
    public const BLACK_HAS_MODERATE_KINGSIDE_CONTROL_ADVANTAGE = 57;
    public const WHITE_HAS_DECISIVE_KINGSIDE_CONTROL_ADVANTAGE = 58;
    public const BLACK_HAS_DECISIVE_KINGSIDE_CONTROL_ADVANTAGE = 59;
    public const WHITE_HAS_SLIGHT_QUEENSIDE_CONTROL_ADVANTAGE = 60;
    public const BLACK_HAS_SLIGHT_QUEENSIDE_CONTROL_ADVANTAGE = 61;
    public const WHITE_HAS_MODERATE_QUEENSIDE_CONTROL_ADVANTAGE = 62;
    public const BLACK_HAS_MODERATE_QUEENSIDE_CONTROL_ADVANTAGE = 63;
    public const WHITE_HAS_DECISIVE_QUEENSIDE_CONTROL_ADVANTAGE = 64;
    public const BLACK_HAS_DECISIVE_QUEENSIDE_CONTROL_ADVANTAGE = 65;
    public const WHITE_HAS_VULNERABLE_FIRST_RANK = 66;
    public const BLACK_HAS_VULNERABLE_FIRST_RANK = 67;
    public const WHITE_HAS_WELL_PROTECTED_FIRST_RANK = 68;
    public const BLACK_HAS_WELL_PROTECTED_FIRST_RANK = 69;
    public const WHITE_HAS_POORLY_PROTECTED_KING = 70;
    public const BLACK_HAS_POORLY_PROTECTED_KING = 71;
    public const WHITE_HAS_WELL_PROTECTED_KING = 72;
    public const BLACK_HAS_WELL_PROTECTED_KING = 73;
    public const WHITE_HAS_POORLY_PLACED_KING = 74;
    public const BLACK_HAS_POORLY_PLACED_KING = 75;
    public const WHITE_HAS_WELL_PLACED_KING = 76;
    public const BLACK_HAS_WELL_PLACED_KING = 77;
    public const WHITE_HAS_VERY_WEAK_PAWN_STRUCTURE = 78;
    public const BLACK_HAS_VERY_WEAK_PAWN_STRUCTURE = 79;
    public const WHITE_HAS_MODERATELY_WEAK_PAWN_STRUCTURE = 80;
    public const BLACK_HAS_MODERATELY_WEAK_PAWN_STRUCTURE = 81;
    public const WHITE_HAS_MODERATELY_STRONG_PAWN_STRUCTURE = 82;
    public const BLACK_HAS_MODERATELY_STRONG_PAWN_STRUCTURE = 83;
    public const WHITE_HAS_VERY_STRONG_PAWN_STRUCTURE = 84;
    public const BLACK_HAS_VERY_STRONG_PAWN_STRUCTURE = 85;
    public const WHITE_HAS_POOR_KNIGHT_PLACEMENT = 86;
    public const BLACK_HAS_POOR_KNIGHT_PLACEMENT = 87;
    public const WHITE_HAS_GOOD_KNIGHT_PLACEMENT = 88;
    public const BLACK_HAS_GOOD_KNIGHT_PLACEMENT = 89;
    public const WHITE_HAS_POOR_BISHOP_PLACEMENT = 90;
    public const BLACK_HAS_POOR_BISHOP_PLACEMENT = 91;
    public const WHITE_HAS_GOOD_BISHOP_PLACEMENT = 92;
    public const BLACK_HAS_GOOD_BISHOP_PLACEMENT = 93;
    public const WHITE_HAS_POOR_ROOK_PLACEMENT = 94;
    public const BLACK_HAS_POOR_ROOK_PLACEMENT = 95;
    public const WHITE_HAS_GOOD_ROOK_PLACEMENT = 96;
    public const BLACK_HAS_GOOD_ROOK_PLACEMENT = 97;
    public const WHITE_HAS_POOR_QUEEN_PLACEMENT = 98;
    public const BLACK_HAS_POOR_QUEEN_PLACEMENT = 99;
    public const WHITE_HAS_GOOD_QUEEN_PLACEMENT = 100;
    public const BLACK_HAS_GOOD_QUEEN_PLACEMENT = 101;
    public const WHITE_HAS_POOR_PIECE_COORDINATION = 102;
    public const BLACK_HAS_POOR_PIECE_COORDINATION = 103;
    public const WHITE_HAS_GOOD_PIECE_COORDINATION = 104;
    public const BLACK_HAS_GOOD_PIECE_COORDINATION = 105;
    public const WHITE_HAS_PLAYED_THE_OPENING_VERY_POORLY = 106;
    public const BLACK_HAS_PLAYED_THE_OPENING_VERY_POORLY = 107;
    public const WHITE_HAS_PLAYED_THE_OPENING_POORLY = 108;
    public const BLACK_HAS_PLAYED_THE_OPENING_POORLY = 109;
    public const WHITE_HAS_PLAYED_THE_OPENING_WELL = 110;
    public const BLACK_HAS_PLAYED_THE_OPENING_WELL = 111;
    public const WHITE_HAS_PLAYED_THE_OPENING_VERY_WELL = 112;
    public const BLACK_HAS_PLAYED_THE_OPENING_VERY_WELL = 113;
    public const WHITE_HAS_PLAYED_THE_MIDDLEGAME_VERY_POORLY = 114;
    public const BLACK_HAS_PLAYED_THE_MIDDLEGAME_VERY_POORLY = 115;
    public const WHITE_HAS_PLAYED_THE_MIDDLEGAME_POORLY = 116;
    public const BLACK_HAS_PLAYED_THE_MIDDLEGAME_POORLY = 117;
    public const WHITE_HAS_PLAYED_THE_MIDDLEGAME_WELL = 118;
    public const BLACK_HAS_PLAYED_THE_MIDDLEGAME_WELL = 119;
    public const WHITE_HAS_PLAYED_THE_MIDDLEGAME_VERY_WELL = 120;
    public const BLACK_HAS_PLAYED_THE_MIDDLEGAME_VERY_WELL = 121;
    public const WHITE_HAS_PLAYED_THE_ENDING_VERY_POORLY = 122;
    public const BLACK_HAS_PLAYED_THE_ENDING_VERY_POORLY = 123;
    public const WHITE_HAS_PLAYED_THE_ENDING_POORLY = 124;
    public const BLACK_HAS_PLAYED_THE_ENDING_POORLY = 125;
    public const WHITE_HAS_PLAYED_THE_ENDING_WELL = 126;
    public const BLACK_HAS_PLAYED_THE_ENDING_WELL = 127;
    public const WHITE_HAS_PLAYED_THE_ENDING_VERY_WELL = 128;
    public const BLACK_HAS_PLAYED_THE_ENDING_VERY_WELL = 129;
    public const WHITE_HAS_SLIGHT_COUNTERPLAY = 130;
    public const BLACK_HAS_SLIGHT_COUNTERPLAY = 131;
    public const WHITE_HAS_MODERATE_COUNTERPLAY = 132;
    public const BLACK_HAS_MODERATE_COUNTERPLAY = 133;
    public const WHITE_HAS_DECISIVE_COUNTERPLAY = 134;
    public const BLACK_HAS_DECISIVE_COUNTERPLAY = 135;
    public const WHITE_HAS_MODERATE_TIME_CONTROL_PRESSURE = 136;
    public const BLACK_HAS_MODERATE_TIME_CONTROL_PRESSURE = 137;
    public const WHITE_HAS_SEVERE_TIME_CONTROL_PRESSURE = 138;
    public const BLACK_HAS_SEVERE_TIME_CONTROL_PRESSURE = 139;

    /**
     * Get the text representation of a NAG value.
     * 
     * @param int $nag The NAG value.
     * @return string The text representation of the NAG value.
     */
    public static function get(int $nag): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();
        $text = array_search($nag, $constants);
        if ($text === false) {
            throw new \InvalidArgumentException('Invalid NAG value');
        }
        $text = strtolower(str_replace('_', ' ', $text));
        return $text;
    }
}
