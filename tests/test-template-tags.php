<?php

class Test_Template_Tags_CoAuthors extends CoAuthorsPlus_TestCase {

	/**
	 * Test get Co-Authors function
	 */
	public function test_is_coauthor_for_post() {

		// Test only sending user
		$this->assertEquals( false, is_coauthor_for_post( '' ) );

		// Test sending user but not post_id
		$this->assertEquals( false, is_coauthor_for_post( $this->author1 ) );

		// Test sending valid post but no user
		$this->assertEquals( false, is_coauthor_for_post( '', 1 ) );

		// Check if author1_post1 belongs to author1 as set in coauthorsplus-testcase.php
		$this->assertTrue( is_coauthor_for_post( $this->author1, $this->author1_post1 ) );

		// Check if author1_post1 does not belongs to editor1 as set in coauthorsplus-testcase.php
		$this->assertFalse( is_coauthor_for_post( $this->editor1, $this->author1_post1 ) );

		$this->go_to( '?p=' . $this->author1_post1 );
		setup_postdata( get_post( $this->author1_post1 ) );

		$this->assertTrue( is_coauthor_for_post( $this->author1 ) );
	}

	public function test_coauthors() {

		$this->go_to( '?p=' . $this->author1_post1 );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertContains( 'author1', $coauthor );

		wp_reset_postdata();

	}

	public function test_coauthors_post_links() {

		$this->go_to( '?p=' . $this->author1_post1 );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors_posts_links', array() );
		$this->assertContains( '<a href="', $coauthor );
		$this->assertContains( '>author1</a>', $coauthor);

		wp_reset_postdata();
	}

	public function test_coauthors_firstnames() {

		$this->go_to( '?p=' . $this->author1_post1 );
		update_user_meta( $this->author1, 'first_name', 'first' );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors_firstnames', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertContains( 'first', $coauthor );

		wp_reset_postdata();
	}

	public function test_coauthors_lastnames() {

		$this->go_to( '?p=' . $this->author1_post1 );
		update_user_meta( $this->author1, 'last_name', 'last' );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors_lastnames', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertContains( 'last', $coauthor );

		wp_reset_postdata();
	}

	public function test_coauthors_nicknames() {

		$this->go_to( '?p=' . $this->author1_post1 );
		update_user_meta( $this->author1, 'nickname', 'nickname' );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors_nicknames', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertContains( 'nickname', $coauthor );

		wp_reset_postdata();
	}

	public function test_coauthors_emails() {

		$this->go_to( '?p=' . $this->author1_post1 );

		setup_postdata( get_post( $this->author1_post1 ) );
		$user = get_userdata( $this->author1 );

		$coauthor = get_echo( 'coauthors_emails', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertContains( $user->user_email, $coauthor );

		wp_reset_postdata();
	}

	public function test_coauthors_IDs() {

		$this->go_to( '?p=' . $this->author1_post1 );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors_IDs', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertEquals( $this->author1, $coauthor );

		wp_reset_postdata();
	}

	public function test_coauthors_links() {

		$this->go_to( '?p=' . $this->author1_post1 );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_echo( 'coauthors_links', array() );
		$this->assertNotContains( '<a href="', $coauthor );
		$this->assertNotContains( '>author1</a>', $coauthor);
		$this->assertContains( 'author1', $coauthor);

		wp_reset_postdata();
	}

	public function test_get_the_coauthor_meta() {

		update_user_meta( $this->author1, 'testmeta', 'testmeta' );
		$this->go_to( '?p=' . $this->author1_post1 );

		setup_postdata( get_post( $this->author1_post1 ) );

		$coauthor = get_the_coauthor_meta( 'testmeta');
		$this->assertEquals( 'testmeta', $coauthor[$this->author1] );

		wp_reset_postdata();
	}

	public function test_coauthors_wp_list_authors() {

		$coauthors = get_echo( 'coauthors_wp_list_authors', array() );
		$this->assertContains( 'author1', $coauthors );
	}

	public function test_coauthors_get_avatar() {
		$coauthors = get_echo( 'coauthors_get_avatar', array( $this->author1 ) );

		$this->assertEmpty( $coauthors );
	}
}
